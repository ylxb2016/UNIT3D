<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Recipe;
use App\Category;
use \Toastr;

class RecipeController extends Controller
{
    /**
     * Add A Recipe
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Grab The Current Authorized User
        $user = auth()->user();

        // Find The Right Category
        $category = Category::findOrFail($request->input('category_id'));

        // Create A Recipe (DB)
        $recipe = new Recipe();
        $recipe->name = $request->input('name');
        $recipe->description = $request->input('description');
        $recipe->category_id = $category->id;
        $recipe->type = $request->input('type');
        $recipe->imdb = $request->input('imdb');
        $recipe->tmdb = $request->input('tmdb');
        $recipe->status = $request->input('status');
        $recipe->info_hash = $request->input('info_hash');
        $recipe->user_id = $user->id;

        // Validation
        $v = validator($recipe->toArray(), [
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'type' => 'required',
            'imdb' => 'required|numeric',
            'tmdb' => 'required|numeric',
            'status' => 'required',
            'user_id' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->route('home')
                ->with(Toastr::error($v->errors()->toJson(), 'Whoops!', ['options']));
        } else {

            // Save The Recipe
            $recipe->save();

            // Activity Log
            \LogActivity::addToLog("Member {$user->username} has added a new recipe to the cooker.");

            return redirect()->route('home')
                ->with(Toastr::success('Your Recipe Has Been Successfully Added To The Cooker!', 'Yay!', ['options']));
        }
    }

    /**
     * Update A Recipe
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Destroy A Recipe
     *
     * @param $uid
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
    }
}
