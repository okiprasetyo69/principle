<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\CategoryApiController;
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
    Route::post('/user', 'register')->name('user.register');
});

// Category
Route::controller(CategoryApiController::class)->group(function() {
    Route::get('/category', 'getCategory')->name('category.data');
    Route::post('/category', 'create')->name('category.register');
});