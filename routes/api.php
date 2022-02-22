<?php

use App\Http\Controllers\api\ApiProduct;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
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

#Route::middleware('auth:api')->get('/user', function (Request $request) {
#    return $request->user();
#});

Route::get('/product/{id}', [ProductController::class, 'getProduct']);
Route::get('/products/{code}', [ApiProduct::class, 'getByCode']);

Route::get('/partner/{id}', [PartnerController::class, 'getPartner']);
Route::get('/customer', [PartnerController::class, 'getAllCustomer'])->name('customer');
Route::get('/chart', [HomeController::class, 'getChart']);
