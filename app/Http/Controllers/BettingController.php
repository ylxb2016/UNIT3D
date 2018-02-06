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

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Bet;
use App\Game;
use App\User;
use App\Outcome;
use App\Bank;
use App\Http\Requests;

class BettingController extends Controller
{
    public function index()
    {
    	return view('betting.index')->with('games', Game::with('outcomes')->get());
    }

    public function show($id)
    {
    	if($game = Game::with('outcomes')->find($id)){
    		$outcomes = Outcome::select('outcome_name', 'total_volume_pending')->where('game_id', $id)->get();
    		return view('betting.show')->with(compact('game', 'outcomes'));
    	}
    	return redirect('/');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		"outcome_name" => "required|string",
    		"odds" => "required",
    		"amount" => "required|numeric|min:1|max:".Auth::user()->bon,
    	]);

    	$bet = Bet::createBet($request);
        Bank::updateBankBalance($bet->stake);
    	Outcome::updateOutcomes($bet);
    	Bet::matchBets($bet);
        User::updateAccountBalance($bet);

    	return redirect('/bet/'.$request->gameId);
    }
}
