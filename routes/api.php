<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\PlaylistController;
use App\Http\Controllers\API\RegisterController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [LoginController::class, 'login']);
Route::get('categories', [SongController::class, 'getCategories']);
Route::post('logout', [LoginController::class, 'logout']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::prefix('users')->group(function () {
        Route::get('{id}', [UserController::class, 'profile']);
        Route::put('{id}/update', [UserController::class, 'update']);
        Route::post('user', [LoginController::class, 'getAuthenticatedUser']);
        Route::post('me', [LoginController::class, 'me']);
        Route::put('change-password', [UserController::class, 'changePassword']);
    });
    Route::prefix('songs')->group(function () {
        Route::get('my-songs/{id}', [SongController::class, 'getMySongs']);
        Route::post('create-song', [SongController::class, 'store']);
        Route::get('{id}/detailSong', [SongController::class, 'getSongById']);
        Route::put('{id}/update', [SongController::class, 'update']);
        Route::get('{id}/delete', [SongController::class, 'delete']);
    });
    Route::prefix('playlists')->group(function () {
        Route::post('create-playlist', [PlaylistController::class, 'store']);
        Route::get('my-playlist/{id}', [PlaylistController::class, 'myPlaylist']);
        Route::get('{id}/get-playlist', [PlaylistController::class, 'getById']);
        Route::get('{id}/get-songs', [PlaylistController::class, 'getSong']);
        Route::post('add-song', [PlaylistController::class, 'addSong']);
        Route::get('{id}/delete', [PlaylistController::class, 'delete']);
    });
});

Route::prefix('songs')->group(function () {
    Route::get('list', [SongController::class, 'getAll']);
    Route::get('{id}/play', [SongController::class, 'detailSong']);
    Route::get('search/{name}', [SongController::class, 'search']);
});

Route::get('new-songs', [SongController::class, 'getNewSongs']);


