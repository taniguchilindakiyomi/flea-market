<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripeController;

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

Route::get('/', [ItemController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'getDetail']);



Route::middleware('auth')->group(function () {
    Route::get('/mypage', [ProfileController::class, 'getMypage']);
    Route::get('/mypage/profile', [ProfileController::class, 'getProfile']);
    Route::post('/mypage/profile', [ProfileController::class, 'postProfile']);

    Route::get('/purchase/{item_id}', [PurchaseController::class, 'getPurchase']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'postPurchase']);
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'getAddress']);
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'postAddress']);
    Route::get('/purchase/success/{item_id}', [PurchaseController::class, 'paymentSuccess']);
    Route::get('/purchase/cancel/{item_id}', [PurchaseController::class, 'paymentCancel']);
    Route::get('/stripe/payment/{paymentIntent}', [StripeController::class, 'showPaymentPage']);

    Route::get('/sell', [ItemController::class, 'getSell']);
    Route::post('/sell', [ItemController::class, 'postSell']);

    Route::post('/item/{item_id}/comment', [ItemController::class, 'postComment']);

    Route::post('/item/{item}/favorite', [ItemController::class, 'storeFavorite']);


});

