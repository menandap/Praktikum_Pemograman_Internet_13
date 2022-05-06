<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


// Route::prefix('user')->name('user.')->group(function () {
   
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product', [HomeController::class, 'product'])->name('homeproduct');
Route::get('/product/{id}', [HomeController::class, 'detail_product'])->name('homeproductdetail');
Route::get('/home', [AuthController::class, 'homepage'])->middleware('auth')->name('homepage');
Route::get('/usr-cart', [AuthController::class, 'cart'])->middleware('auth')->name('cart');
Route::get('/usr-product', [AuthController::class, 'product'])->middleware('auth')->name('product');
Route::get('/usr-product/{id}', [AuthController::class, 'detail_product'])->middleware('auth')->name('detail_product');


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::resource('admin', 'AdminController');
Route::resource('user', 'UserController');
Route::resource('productcontroller', 'ProductCategoriesController');

