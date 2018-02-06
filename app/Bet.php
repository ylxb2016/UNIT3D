<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://choosealicense.com/licenses/gpl-3.0/  GNU General Public License v3.0
 * @author     HDVinnie
 */

namespace App;

use Auth;
use App\Bank;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class Bet extends Model
{
    public function user(){
    	return $this->belongsTo(\App\User::class);
    }

    public function game(){
        return $this->belongsTo(\App\Game::class);
    }

    public function scopeAmountStillPending($query){
    	return $query->where('pending_amount', '!=', 0);
    }

    public function scopeWhereActive($query){
    	return $query->where('status', 'active');
    }

    public function payout(){
        $user = User::find($this->user_id);
        //Handle fully-filled winning bets
        if($this->pending_amount == 0){
            $this->status = "Won";
            $user->bon = $user->bon + ($this->total_amount - $this->pending_amount);
            Bank::updateBankBalance(-$this->total_amount - $this->pending_amount);
        }
        //Handle partially filled winning bets
        elseif($this->pending_amount > 0){
            $this->status = "Partially Won";
            $stakeFilled = $this->stake * (100 / $this->total_amount * ($this->total_amount - $this->pending_amount)) / 100;
            $winningsFromFilled = $stakeFilled * $this->odds;
            $stakeUnfilled = $this->stake - $stakeFilled;
            $user->bon = $user->bon + $winningsFromFilled + $stakeUnfilled;
            Bank::updateBankBalance(-$winningsFromFilled - $stakeUnfilled);
        }
        $this->save();
        $user->save();
    }

    public static function createBet(Request $request){
    	$bet = new Bet;
    	$bet->user_id = Auth::id();
    	$bet->game_id = $request->gameId;
    	$bet->outcome_name = $request->outcome_name;
    	$bet->odds = $request->odds;
    	$bet->stake = $request->amount;
    	$bet->total_amount = $request->amount * $request->odds;
    	$bet->pending_amount = $request->amount * $request->odds;
    	$bet->save();
    	return $bet;
    }

    public static function matchBets(Bet $currentBet){
    	Bet::adjustVolume($currentBet);
    	Bet::fillPendingBets($currentBet);
    }

    public static function adjustVolume(Bet $currentBet){
    	$currentOutcome = Outcome::where(['game_id' => $currentBet->game_id, 'outcome_name' => $currentBet->outcome_name])->first();
    	$oppositeOutcome = Outcome::getOppositeOutcome($currentBet->game_id, $currentBet->outcome_name);
    	if($oppositeOutcome->total_volume_pending >= $currentOutcome->total_volume_pending){
    		$oppositeOutcome->total_volume_pending = $oppositeOutcome->total_volume_pending - $currentOutcome->total_volume_pending;
    		$currentOutcome->total_volume_pending = 0;
    	}
    	elseif($oppositeOutcome->total_volume_pending < $currentOutcome->total_volume_pending){
    		$currentOutcome->total_volume_pending = $currentOutcome->total_volume_pending - $oppositeOutcome->total_volume_pending;
    		$oppositeOutcome->total_volume_pending = 0;
    	}
		$oppositeOutcome->save();
    	$currentOutcome->save();
    }

    public static function fillPendingBets(Bet $currentBet){
    	$oppositeOutcomeName = Outcome::getOppositeOutcome($currentBet->game_id, $currentBet->outcome_name)->outcome_name;
    	$pendingBet = Bet::whereActive()->where([
    		'game_id' => $currentBet->game_id,
    		'outcome_name' => $oppositeOutcomeName,
    	])
    	->where('pending_amount', '>', 0)
    	->orderBy('odds', 'DESC')
    	->first();

    	if($pendingBet){
    		if($pendingBet->pending_amount >= $currentBet->pending_amount){
    			$pendingBet->pending_amount = $pendingBet->pending_amount - $currentBet->pending_amount;
    			$currentBet->pending_amount = 0;
    			$pendingBet->save();
    			$currentBet->save();
    		}
    		elseif($pendingBet->pending_amount < $currentBet->pending_amount){
    			$currentBet->pending_amount = $currentBet->pending_amount - $pendingBet->pending_amount;
    			$pendingBet->pending_amount = 0;
    			$pendingBet->save();
    			$currentBet->save();

    			//Repeat until $currentBet->pending_amount is 0
    			Bet::fillPendingBets($currentBet);
    		}
    	}
    }

    public static function deactivateUnfilledBets($gameId){
        $unfilledBets = Bet::where('game_id', $gameId)->whereRaw('total_amount = pending_amount')->get();
        foreach($unfilledBets as $bet){
            $bet->status = "cancelled";
            $bet->save();

            $user = User::find($bet->user_id);
            $user->bon = $user->bon + $bet->stake;
            $user->save();

            Bank::updateBankBalance(-$bet->stake);
        }
    }

    public static function payoutWinningBets($gameId, $winningOutcome){
        $winningBets = Bet::whereActive()->where(['game_id' => $gameId, 'outcome_name' => $winningOutcome])->get();
        foreach($winningBets as $bet){
            $bet->payout();
        }
    }

    public static function collectLosingBets($gameId, $winningOutcome){
        $losingBets = Bet::whereActive()->where(['game_id' => $gameId, 'outcome_name' => Outcome::getOppositeOutcome($gameId, $winningOutcome)->outcome_name])->get();
        foreach($losingBets as $bet){
            $bet->status = "Lost";
            $bet->save();

            //Return pending amount on partially filled bets
            $user = User::find($bet->user_id);
            $user->bon = $user->bon + $bet->pending_amount;
            $user->save();

            Bank::updateBankBalance(-$bet->pending_amount);
        }
    }
}
