<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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

/**
 * Routes in this group can only be accessed by users
 * who has the admin role
 */
Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('/roles', RoleController::class)->except([
            'create', 'show', 'edit', 'update'
        ]);
    });

    Route::resource('/users', UserController::class)->except([
        'show'
    ]);
    Route::resource('/roles', RoleController::class)->except([
        'create', 'show', 'edit', 'update'
    ]);

    Route::get('users/roles/{id}', [UserController::class, 'roles'])->name('users.roles');
    Route::put('/users/roles/{id}', [UserController::class, 'setRole'])->name('users.set_role');
    Route::post('/users/permission', [UserController::class, 'addPermission'])->name('users.add_permission');
    Route::get('/users/role-permission', [UserController::class, 'rolePermission'])->name('users.roles_permission');
    Route::put('/users/permission/{role}', [UserController::class, 'setRolePermission'])->name('users.setRolePermission');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);
});

/**
 * Routes that are in this group, can only be accessed by the user
 * which has the permissions mentioned below
 */

Route::group(['middleware' => ['permission:show products|create products|delete products']], function () {
    Route::resource('/categories', CategoryController::class)->except([
        'create', 'show'
    ]);
    Route::resource('/products', ProductController::class);
});

/**
 * Route group for cashier
 */
Route::group(['middleware' => ['role:cashier']], function () {
    Route::get('/transaction', [OrderController::class, 'addOrder'])->name('order.transaction');
    Route::get('add-to-cart/{id}', [OrderController::class, 'addToCart'])->name('add.to.cart');
    Route::patch('update-cart', [OrderController::class, 'updateCart'])->name('update.cart');
    Route::delete('remove-from-cart', [OrderController::class, 'removeCart'])->name('remove.from.cart');
    Route::get('checkout-cart', [OrderController::class, 'checkoutCart'])->name('checkout.from.cart');
    Route::post('checkout', [OrderController::class, 'storeOrder'])->name('order.storeOrder');

    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/order/pdf/{invoice}', [OrderController::class, 'invoicePdf'])->name('order.pdf');
    Route::get('/order/excel/{invoice}', [OrderController::class, 'invoiceExcel'])->name('order.excel');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
