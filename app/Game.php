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

use App\Outcome;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function outcomes(){
    	return $this->hasMany(\App\Outcome::class);
    }

    public function bets(){
    	return $this->hasMany(\App\Bets::class);
    }

    public function winner(){
    	return $this->hasOne(\App\Outcome::class);
    }

    public static function end($gameId, $winningOutcome){
    	$game = Game::find($gameId);
        $game->status = 'ended';
        $game->winning_outcome_id = Outcome::where(['game_id' => $gameId, 'outcome_name' => $winningOutcome])->first()->id;
        $game->save();
    }
}
