<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CategoriesController;

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

Route::get('/register', [RegisterController::class, 'showFormRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register');
Route::get('/', [LoginController::class, 'showFormLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');
Route::get('/changePassword', [LoginController::class, 'showFormChangePassword'])->name('showChangePassword');
Route::post('/changePassword', [LoginController::class, 'changePassword'])->name('changePassword');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('users')->group(function (){
    Route::get('{id}/profile',[\App\Http\Controllers\UserController::class,'profile'])->name('users.profile');
    Route::get('{id}/edit',[\App\Http\Controllers\UserController::class,'edit'])->name('users.edit');
    Route::post('{id}/edit',[\App\Http\Controllers\UserController::class,'update'])->name('users.update');
});

Route::get('/list', [CategoriesController::class, 'index'])->name('categories.list');
