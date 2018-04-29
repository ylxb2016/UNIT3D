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

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Possible solution for translations */
Route::get('/lang/{key}', function ($key) {
    return response(['results' => trans($key)]);
});


Route::namespace('API')->group(function () {

    Route::prefix('forums')->group(function () {

        /* Topics */
        Route::get('/topics', 'ForumTopicsController@all');
        Route::post('/topics', 'ForumTopicsController@create');
        Route::get('/topics/{id}', 'ForumTopicsController@topic');
        Route::post('/topics/{id}', 'ForumTopicsController@update');
        Route::delete('/topics/{id}/delete', 'ForumTopicsController@destroy');
        Route::get('/latest/topics/{limit?}', 'ForumTopicsController@latest');

        /* Posts */
        Route::get('/posts', 'ForumPostsController@all');
        Route::post('/posts', 'ForumPostsController@create');
        Route::get('/posts/{id}', 'ForumPostsController@post');
        Route::post('/posts/{id}', 'ForumPostsController@update');
        Route::delete('/posts/{id}/delete', 'ForumPostsController@destroy');
        Route::get('/latest/posts/{limit?}', 'ForumPostsController@latest');
    });
});