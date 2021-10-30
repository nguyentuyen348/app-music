<?php

use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/register',[RegisterController::class,'showFormRegister'])->name('register');
Route::post('/register',[RegisterController::class,'register'])->name('auth.register');

Route::prefix('users')->group(function (){
    Route::get('{id}/profile',[\App\Http\Controllers\UserController::class,'profile'])->name('users.profile');
    Route::get('{id}/edit',[\App\Http\Controllers\UserController::class,'edit'])->name('users.edit');
    Route::post('{id}/edit',[\App\Http\Controllers\UserController::class,'update'])->name('users.update');
});
