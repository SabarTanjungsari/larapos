<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PartnerController;
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

    Route::resource('/roles', RoleController::class);
    Route::resource('/users', UserController::class);

    Route::resource('/categories', CategoryController::class);
    Route::resource('/products', ProductController::class);
    Route::resource('/partners', PartnerController::class);

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
