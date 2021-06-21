<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
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

Route::get('/product/{id}', [OrderController::class, 'getProduct']);
Route::get('/partner/{id}', [OrderController::class, 'getPartner']);
Route::get('/partner', [OrderController::class, 'getAllPartner'])->name('partner');
Route::get('/chart', [HomeController::class, 'getChart']);
