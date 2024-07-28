<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\PurchaseOrderApiController;
use App\Http\Controllers\Api\DistributorStockApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User
Route::controller(UserApiController::class)->group(function() {
    Route::get('/user', 'getUser')->name('user.data');
    Route::get('/user/distributor', 'getDistributor')->name('user.distributor');
    Route::post('/user', 'register')->name('user.register');
});

// Category
Route::controller(CategoryApiController::class)->group(function() {
    Route::get('/category', 'getCategory')->name('category.data');
    Route::post('/category', 'create')->name('category.register');
    Route::delete('/category', 'delete')->name('category.delete');
});

// Product
Route::controller(ProductApiController::class)->group(function() {
    Route::get('/product', 'getProduct')->name('product.data');
    Route::post('/product', 'create')->name('product.create');
    Route::post('/product/update', 'update')->name('product.update');
    Route::get('/product/{id}', 'detail')->name('product.detail');
    Route::delete('/product', 'delete')->name('product.delete');
});

// Purchase Order
Route::controller(PurchaseOrderApiController::class)->group(function() {
    Route::get('/purchase-order', 'getPurchaseOrder')->name('purchase-order.data');
    Route::post('/purchase-order', 'create')->name('purchase-order.create');
    Route::get('/purchase-order/{id}', 'detail')->name('purchase-order.detail');
    Route::delete('/purchase-order/{id}', 'delete')->name('purchase-order.delete');
});

// Distributor Stock
Route::controller(DistributorStockApiController::class)->group(function() {
    Route::get('/distributor/stock', 'getDistributorStockItem')->name('distributor.stock');
    Route::post('/distributor/stock', 'create')->name('category.register');
    Route::delete('/distributor/stock', 'delete')->name('distributor.stock.delete');
    Route::get('/stock/per-distributor', 'getStockPerDistributor')->name('stock.per-distributor');
});