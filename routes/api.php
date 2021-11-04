<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SongController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::prefix('users')->group(function () {
        Route::get('{id}', [UserController::class, 'profile']);
        Route::put('{id}/update', [UserController::class, 'update']);
        Route::post('user', [LoginController::class, 'getAuthenticatedUser']);
        Route::post('create-song', [SongController::class, 'store']);
    });
});


