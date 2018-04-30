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

    Route::prefix('chat')->group(function () {

        /* Rooms */
        Route::get('/rooms', 'ChatController@rooms');
        Route::post('/rooms', 'ChatController@createRoom');
        Route::put('/rooms/{id}', 'ChatController@updateRoom');
        Route::delete('/rooms/{id}', 'ChatController@destroyRoom');

        /* Messages */
        Route::get('/messages', 'ChatController@messages');
        Route::post('/messages', 'ChatController@createMessage');
        Route::put('/message/{id}', 'ChatController@updateMessage');
        Route::delete('/messages/{id}', 'ChatController@destroyRoom');

    });

    Route::prefix('forums')->group(function () {

        /* Topics */
        Route::get('/topics', 'ForumTopicsController@all');
        Route::post('/topics', 'ForumTopicsController@create');
        Route::get('/topics/{id}', 'ForumTopicsController@topic');
        Route::put('/topics/{id}', 'ForumTopicsController@update');
        Route::delete('/topics/{id}', 'ForumTopicsController@destroy');
        Route::get('/latest/topics/{limit?}', 'ForumTopicsController@latest');

        /* Posts */
        Route::get('/posts', 'ForumPostsController@all');
        Route::post('/posts', 'ForumPostsController@create');
        Route::get('/posts/{id}', 'ForumPostsController@post');
        Route::put('/posts/{id}', 'ForumPostsController@update');
        Route::delete('/posts/{id}', 'ForumPostsController@destroy');
        Route::get('/latest/posts/{limit?}', 'ForumPostsController@latest');
    });
});