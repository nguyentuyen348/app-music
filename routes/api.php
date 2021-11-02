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

Route::post('login',[\App\Http\Controllers\API\LoginController::class, 'login']);

Route::prefix('users')->group(function (){
    Route::get('{id}/profile',[\App\Http\Controllers\API\UserController::class, 'profile']);
    Route::put('{id}/update',[\App\Http\Controllers\API\UserController::class, 'update']);
});

