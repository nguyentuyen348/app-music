<?php

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

Route::post('register', [\App\Http\Controllers\API\RegisterController::class, 'register']);
Route::post('login', [\App\Http\Controllers\API\LoginController::class, 'login']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('logout', [\App\Http\Controllers\API\LoginController::class, 'logout']);
    Route::prefix('users')->group(function (){
        Route::get('{id}/profile',[\App\Http\Controllers\API\UserController::class, 'profile']);
        Route::put('{id}/update',[\App\Http\Controllers\API\UserController::class, 'update']);
        Route::post('user', [\App\Http\Controllers\API\LoginController::class, 'getAuthenticatedUser']);
    });
    
});



