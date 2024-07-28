<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/principal', [PrincipalController::class, 'index'])->name('principal')->middleware('principal');
Route::get('/principal/stock', [PrincipalController::class, 'principalStock'])->name('principal.stock')->middleware('principal');
Route::get('/list-distributor', [PrincipalController::class, 'listDistributor'])->name('principal.list-distributor')->middleware('principal');
Route::get('/distributor/stock/{id}', [PrincipalController::class, 'monitorStockOnDistributor'])->name('principal.distributor.stock')->middleware('principal');

Route::get('/category', [CategoryController::class, 'index'])->name('category')->middleware('principal');

Route::get('/product', [ProductController::class, 'index'])->name('product')->middleware('principal');
Route::get('/product/new', [ProductController::class, 'addProduct'])->name('product.new')->middleware('principal');
Route::get('/product/{id}', [ProductController::class, 'edit'])->name('product.edit')->middleware('principal');

Route::get('/distributor', [DistributorController::class, 'index'])->name('distributor')->middleware('distributor');
Route::get('/distributor/product', [DistributorController::class, 'listProduct'])->name('distributor.product')->middleware('distributor');
Route::get('/distributor/stock', [DistributorController::class, 'listStock'])->name('distributor.stock')->middleware('distributor');
Route::get('/distributor/product/load-more', [DistributorController::class, 'loadMoreProductPaginate'])->name('distributor.product.load-more')->middleware('distributor');
Route::get('/distributor/purchase-order', [DistributorController::class, 'distributorPurchaseOrder'])->name('distributor.purhcase-order')->middleware('distributor');
Route::get('/distributor/purchase-order/new', [DistributorController::class, 'addPurchaseOrder'])->name('distributor.purhcase-order.add')->middleware('distributor');
Route::get('/distributor/{product_name}/{id}', [DistributorController::class, 'detailProduct'])->name('distributor.detail.product')->middleware('distributor');

Route::get('/forbidden', function () {
    return view('forbidden');
})->name('forbidden');