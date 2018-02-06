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

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Bet;
use App\Game;
use App\Outcome;
use App\Bank;


class GamesController extends Controller
{
    public function index()
    {
    	return view('games.index')->with(['games' => Game::all(), 'bank' => Bank::bankBalance()]);
    }

    public function show($id)
    {
    	if($game = Game::with('outcomes')->find($id)){
    		$pendingBets = Bet::where('game_id', $id)->where('pending_amount', '>', 0)->orderBy('odds', 'desc')->get();
    		$filledBets = Bet::where('game_id', $id)->where('pending_amount', 0)->orderBy('odds', 'desc')->get();
    		$outcomes = Outcome::select('outcome_name', 'total_volume_pending')->where('game_id', $id)->get();
    		return view('games.show')->with(compact('game', 'pendingBets', 'filledBets', 'outcomes'));
    	}
    	return redirect('/');
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
    		'game_name' => 'required|string|unique:games|max:255',
    		'outcome_1_name' => 'required|string|max:255',
    		'outcome_2_name' => 'required|string|max:255',
            'outcome_1_odds' => 'required|numeric|min:1',
            'outcome_2_odds' => 'required|numeric|min:1',
    	]);

    	$game = new Game;
    	$game->game_name = $request->game_name;
        $game->game_start_time = Carbon::now();
    	$game->save();

        DB::table('outcomes')->insert([
            ['game_id' => $game->id, 'outcome_name' => $request->outcome_1_name, 'outcome_odds' => $request->outcome_1_odds, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['game_id' => $game->id, 'outcome_name' => $request->outcome_2_name, 'outcome_odds' => $request->outcome_2_odds, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

    	return redirect('/games');
    }

    public function declareWinner(Request $request)
    {
        Bet::deactivateUnfilledBets($request->gameId);
        Bet::payoutWinningBets($request->gameId, $request->winningOutcome);
        Bet::collectLosingBets($request->gameId, $request->winningOutcome);
        Game::end($request->gameId, $request->winningOutcome);
        return redirect()->back();
    }
}
