<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect(route('login'));
});
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::resource('/category', CategoryController::class)->except([
        'create', 'show'
    ]);
    Route::resource('/product', ProductController::class);
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('/role', RoleController::class)->except([
        'create', 'show', 'edit', 'update'
    ]);
    Route::resource('/user', UserController::class)->except([
        'show'
    ]);
    Route::get('user/roles/{id}', [UserController::class, 'roles'])->name('user.roles');
});
