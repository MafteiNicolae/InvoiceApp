<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return inertia('Index/Index');
})->name('home');

Route::controller(AuthController::class)->group(function(){
    Route::get('login', 'create')->name('login');
    Route::post('loginStore', 'store')->name('login.store');
    Route::post('logout', 'logout')->name('logout');
    Route::get('email/verify', 'verifyEmail')->middleware('auth')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'verificationEmail')->middleware(['auth', 'signed'])->name('verification.verify');
    Route::post('/email/verification-notification', 'resendVerifEmail')->middleware(['auth', 'throttle:6,1'])->name('verification.send');
    Route::get('/forgot-password', 'forgotPassword')->middleware('guest')->name('password.request');
    Route::post('/forgot-password', 'passwordEmail')->middleware('guest')->name('password.email');
    Route::get('/reset-password/{token}', 'passwordReset')->middleware('guest')->name('password.reset');
    Route::post('/reset-password', 'passwordUpdate')->middleware('guest')->name('password.update');
});

Route::controller(RegisterController::class)->group(function(){
    Route::get('register', 'create')->name('register');
    Route::post('register', 'store')->name('register.store');
});

Route::controller(CustomerController::class)->prefix('customer')->name('customer.')->middleware(['auth', 'verified'])->group(function(){
    Route::get('index', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::get('edit/{customer}', 'edit')->name('edit');
    Route::post('update/{customer}', 'update')->name('update');
    Route::delete('delete/{customer}', 'delete')->name('delete');
    Route::delete('delete/{ids}/bulk', 'deleteBulk')->name('deleteBulk');
});

Route::controller(ProductController::class)->prefix('product')->name('product.')->middleware(['auth', 'verified'])->group(function(){
    Route::get('index', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::get('edit/{product}', 'edit')->name('edit');
    Route::post('update/{product}', 'update')->name('update');
    Route::delete('delete/{product}', 'delete')->name('delete');
    Route::delete('delete/{ids}/bulk', 'deleteBulk')->name('deleteBulk');
});

Route::controller(InvoiceController::class)->prefix('invoice')->name('invoice.')->middleware(['auth', 'verified'])->group(function(){
    Route::get('index', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::post('store', 'store')->name('store');
    Route::get('show/{invoice}', 'show')->name('show');
    Route::get('edit/{invoice}', 'edit')->name('edit');
    Route::post('update/{invoice}', 'update')->name('update');
    Route::delete('delete/{invoice}', 'delete')->name('delete');
    Route::delete('delete/{ids}/bulk', 'deleteBulk')->name('deleteBulk');
});
