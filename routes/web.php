<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/homeproduct', [HomeController::class, 'product'])->name('homeproduct');
Route::get('/home-detail-product', [HomeController::class, 'detailproduct'])->name('homedetailproduct');
Route::get('/home', [AuthController::class, 'homepage'])->middleware('auth')->name('homepage');
Route::get('/cart', [AuthController::class, 'cart'])->middleware('auth')->name('cart');
Route::get('/product', [AuthController::class, 'product'])->middleware('auth')->name('product');
Route::get('/detail-product', [AuthController::class, 'detailproduct'])->middleware('auth')->name('detailproduct');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';