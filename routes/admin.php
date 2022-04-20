<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RegisteredAdminController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () { //membatasi jika user akan mengakses route dibawah jadi alternatif nya /admin/home
        Route::view('/login', 'admin.auth.login')->name('login'); //admin.login
        Route::post('/login', [AuthController::class, 'store'])->name('login');
        Route::view('/register', 'admin.auth.register')->name('register');
        Route::post('/register', [RegisteredAdminController::class, 'store']);
    });

    Route::middleware(['auth:admin'])->group(function () {
        Route::view('/home', 'admin.home')->name('home');
        Route::view('/dummy', 'admin.dummy')->name('dummy');
        Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
    });
});