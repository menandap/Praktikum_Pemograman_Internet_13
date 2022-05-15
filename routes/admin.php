<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RegisteredAdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\DiscountController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\TransactionsController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () { //membatasi jika user akan mengakses route dibawah jadi alternatif nya /admin/home
        Route::view('/login', 'admin.auth.login')->name('login'); //admin.login
        Route::post('/login', [AuthController::class, 'store'])->name('login');
        Route::view('/register', 'admin.auth.register')->name('register');
        Route::post('/register', [RegisteredAdminController::class, 'store']);
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('/home',[AuthController::class, 'dashboard']);
        Route::get('/dummy', [AuthController::class, 'dummy'])->name('dummy');

        Route::get('/transactions', [TransactionsController::class, 'transaksi'])->name('adm-transaksi');
        Route::get('/transactions/detail/{id}', [TransactionsController::class, 'transaksi_detail'])->name('adm-transaksi-detail');
        Route::post('/transactions/status/{id}', [TransactionsController::class, 'transaksi_status'])->name('adm-transaksi-status');
        Route::get('/transactions/bukti/{id}', [TransactionsController::class, 'transaksi_bukti'])->name('adm-transaksi-bukti');
        
        Route::get('/{id}/addResponse', [ProductController::class, 'addResponse']);
        Route::post('/{id}/addResponse', [ProductController::class, 'uploadResponse']);

        Route::get('/categories', [CategoryController::class, 'index'])->name('category');
        Route::get('/categories/create', [CategoryController::class, 'create']);
        Route::post('/categories/store', [CategoryController::class, 'store']);
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit']);
        Route::post('/categories/{id}/update', [CategoryController::class, 'update']);
        Route::get('/categories/{id}/delete', [CategoryController::class, 'delete']);
        
        Route::get('/products', [ProductController::class, 'index'])->name('product');
        Route::get('/products/create', [ProductController::class, 'create']);
        Route::post('/products/store', [ProductController::class, 'store']);
        Route::get('/products/{id}/show', [ProductController::class, 'show'])->name('productdetail');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
        Route::post('/products/{id}/update', [ProductController::class, 'update']);
        Route::get('/products/{id}/delete', [ProductController::class, 'delete']);

        Route::get('/{id}/addImage', [ProductController::class, 'uploadImage']);
        Route::post('/{id}/addImage', [ProductController::class, 'upload']);
        Route::get('/{id}/deleteImage', [ProductController::class, 'deleteImage']);
      
        Route::get('/{id}/addDiscount', [ProductController::class, 'addDiscount']);
        Route::post('/{id}/addDiscount', [ProductController::class, 'uploadDiscount']);
        Route::get('/{id}/editDiscount', [ProductController::class, 'editDiscount']);
        Route::post('/{id}/editDiscount', [ProductController::class, 'updateDiscount']);
        Route::get('/{id}/deleteDiscount', [ProductController::class, 'deleteDiscount'])->name('deletediskon');

        Route::get('/{id}/addCategory', [ProductController::class, 'addCategory']);
        Route::post('/{id}/addCategory', [ProductController::class, 'uploadCategory']);
        Route::get('/{id}/deleteCategory', [ProductController::class, 'deleteCategory']);

        Route::get('/{id}/addStok', [ProductController::class, 'addStok']);
        Route::post('/{id}/addStok', [ProductController::class, 'uploadStok']);
        Route::get('/{id}/editStok', [ProductController::class, 'editStok']);
        Route::post('/{id}/editStok', [ProductController::class, 'updateStok']);
        Route::get('/{id}/deleteStok', [ProductController::class, 'deleteStok']);
        
        Route::get('/couriers', [CourierController::class, 'index'])->name('courier');
        Route::get('/couriers/create', [CourierController::class, 'create']);
        Route::post('/couriers/store', [CourierController::class, 'store']);
        Route::get('/couriers/{id}/edit', [CourierController::class, 'edit']);
        Route::post('/couriers/{id}/update', [CourierController::class, 'update']);
        Route::get('/couriers/{id}/delete', [CourierController::class, 'delete']);
        
        Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    });
});