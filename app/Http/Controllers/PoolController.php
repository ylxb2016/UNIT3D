<?php
/**
 * NOTICE OF LICENSE.
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 *
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Http\Controllers;

use App\User;
use App\Pool;
use Carbon\Carbon;
use App\PoolTransaction;
use Brian2694\Toastr\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repositories\ChatRepository;

class PoolController extends Controller
{
    /**
     * @var ChatRepository
     */
    private $chat;

    /**
     * @var Toastr
     */
    private $toastr;

    /**
     * PoolController Constructor.
     *
     * @param ChatRepository $chat
     * @param Toastr         $toastr
     */
    public function __construct(ChatRepository $chat, Toastr $toastr)
    {
        $this->chat = $chat;
        $this->toastr = $toastr;
    }

    /**
     * Get A Pool.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $pool = Pool::with('transactions')->where('complete', '=', 0)->first();
        //$top_contributors = PoolTransaction::with('user')->where('pool_id', $pool->id)->select(DB::raw('user_id, count(*) as value'))->groupBy('user_id')->latest('value')->take(10)->sum('bonus_points');

        return view('pool.index', ['pool' => $pool]);
    }

    /**
     * Store Pool Transaction And Activate Goal If Met.
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $id)
    {
        $user = auth()->user();
        $current = Carbon::now();
        $pool = Pool::findOrFail($id);

        $transaction = new PoolTransaction();
        $transaction->user_id = $user->id;
        $transaction->pool_id = $pool->id;
        $transaction->bonus_points = $request->input('bonus_points');
        $transaction->anon = $request->input('anon');

        $v = validator($transaction->toArray(), [
            'user_id'    => 'required',
            'pool_id'    => 'required',
            'bonus_points'  => "required|numeric|min:1|max:{$user->seedbonus}",
            'anon'       => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->route('pool')
                ->with($this->toastr->error($v->errors()->toJson(), 'Whoops!', ['options']));
        } else {
            $user->seedbonus -= $request->input('bonus_points');
            $user->save();

            $transaction->save();

            $total = $pool->current_pot + $transaction->bonus_points;
            $pool->current_pot = $total;
            $pool->save();

            // Announce To Chat
            if ($transaction->anon == 0) {
                $profile_url = hrefProfile($user);
                $this->chat->systemMessage(
                    ":robot: [b][color=#fb9776]System[/color][/b] : [url={$profile_url}]{$user->username}[/url] has contributed ".number_format($transaction->bonus_points)." to the BON pool! "
                );
            } else {
                $this->chat->systemMessage(
                    ":robot: [b][color=#fb9776]System[/color][/b] : An anonymous user has contributed ".number_format($transaction->bonus_points)." to the BON pool! "
                );
            }

            // Activate Pool Reward If Pool Goal Is Met
            if ($pool->current_pot > $pool->goal) {
                $pool->end = $current;
                $pool->complete = 1;
                $pool->save();

                \Artisan::call('clear:all_cache');
                config('other.freeleech', 1);
                config('other.freeleech_until', $current->copy()->addDays(7)->toDateTimeString());
                \Artisan::call('set:all_cache');
                \Artisan::call('opcache:clear');

                $this->chat->systemMessage(
                    ":robot: [b][color=#fb9776]System[/color][/b] : BON Pool goal has been met! Enjoy The FL!"
                );
            }

            return redirect()->route('pool')
                ->with($this->toastr->success('Your Contribution Was Successfully Added', 'Yay!', ['options']));
        }
    }
}
