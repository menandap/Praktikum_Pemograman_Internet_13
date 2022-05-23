<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


// Route::prefix('user')->name('user.')->group(function () {
   
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [AuthController::class, 'homepage'])->middleware('auth')->name('homepage');
Route::get('user/{id}',[AuthController::class,'user_notif'])->name('notification');

Route::get('/product', [HomeController::class, 'product'])->name('homeproduct');
Route::get('/product/{id}', [HomeController::class, 'detail_product'])->name('homeproductdetail');
Route::get('/usr-product', [AuthController::class, 'product'])->middleware('auth')->name('product');
Route::get('/usr-product/{id}', [AuthController::class, 'detail_product'])->middleware('auth')->name('detail_product');

Route::get('/usr-cart', [AuthController::class, 'cart'])->middleware('auth')->name('cart');
Route::post('usr-cart/{id}/add', [AuthController::class, 'cart_add'])->name('keranjang-tambah');
Route::post('usr-cart-buy/{id}/add', [AuthController::class, 'cart_buy'])->name('keranjang-beli');
Route::get('/usr-cart/delete/{id}', [AuthController::class, 'cart_delete'])->name('keranjang-hapus');

Route::post('/usr-cart/address', [AuthController::class, 'cart_address'])->name('keranjang-alamat');
Route::post('/usr-cart/checkout', [AuthController::class, 'cart_checkout'])->name('keranjang-checkout');
Route::post('/usr-cart/confir', [AuthController::class, 'cart_confir'])->name('keranjang-bayar');

// Route::post('/buy/address/{id}', [AuthController::class, 'buy_address'])->name('beli-alamat');
// Route::post('/buy/checkout/{id}/{jumlah}', [AuthController::class, 'buy_checkout'])->name('beli-checkout');
// Route::post('/buy/confir/{id}/{jumlah}', [AuthController::class, 'buy_confir'])->name('beli-bayar');

Route::get('/transaction', [AuthController::class, 'transaction'])->name('transaksi');
Route::get('/transaction/detail/{id}', [AuthController::class, 'transaction_detail'])->name('transaksi-detail');
Route::post('/transaction/bukti/{id}', [AuthController::class, 'transaction_bukti'])->name('transaksi-bukti');
Route::post('/transaction/batal/{id}', [AuthController::class, 'transaction_batal'])->name('transaksi-batal');
Route::post('/transaction/confir/{id}', [AuthController::class, 'transaction_confir'])->name('transaksi-konfirmasi');

Route::post('/{id}/addReview', [AuthController::class, 'uploadReview'])->name('addreview');


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Route::resource('admin', 'AdminController');
Route::resource('user', 'UserController');
Route::resource('productcontroller', 'ProductCategoriesController');

