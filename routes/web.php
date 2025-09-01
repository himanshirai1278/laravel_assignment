<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Customer\AuthController as CustomerAuth;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ImportController;
use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureCustomer;
use Illuminate\Support\Facades\Auth;

// Home
Route::get('/', fn()=> view('welcome'));

// Admin auth
Route::get('/admin/login',[AdminAuth::class,'showLogin'])->name('admin.login');
Route::post('/admin/login',[AdminAuth::class,'login']);
Route::post('/admin/logout',[AdminAuth::class,'logout'])->name('admin.logout');

Route::middleware([EnsureAdmin::class])->prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminAuth::class,'dashboard'])->name('admin.dashboard');
    Route::get('/products',[ProductController::class,'adminIndex'])->name('admin.products');
    Route::get('/products/create',[ProductController::class,'create'])->name('admin.products.create');
    Route::post('/products',[ProductController::class,'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit',[ProductController::class,'edit'])->name('admin.products.edit');
    Route::put('/products/{product}',[ProductController::class,'update'])->name('admin.products.update');
    Route::delete('/products/{product}',[ProductController::class,'destroy'])->name('admin.products.destroy');

    Route::get('/orders',[OrderController::class,'adminList'])->name('admin.orders');
    Route::patch('/orders/{order}/status',[OrderController::class,'updateStatus'])->name('admin.orders.status');

    Route::get('/import',[ImportController::class,'form'])->name('admin.import');
    Route::post('/import',[ImportController::class,'upload'])->name('admin.import.upload');
});

// Customer auth
Route::get('/register',[CustomerAuth::class,'showRegister'])->name('customer.register');
Route::post('/register',[CustomerAuth::class,'register']);
Route::get('/login',[CustomerAuth::class,'showLogin'])->name('customer.login');
Route::post('/login',[CustomerAuth::class,'login']);
Route::post('/logout',[CustomerAuth::class,'logout'])->name('customer.logout');

// Customer area
Route::middleware([EnsureCustomer::class])->group(function(){
    Route::get('/dashboard',[CustomerAuth::class,'dashboard'])->name('customer.dashboard');
    Route::get('/products',[ProductController::class,'index'])->name('customer.products');
    Route::post('/orders',[OrderController::class,'place'])->name('orders.place');
    Route::post('/webpush/subscribe',[\App\Http\Controllers\WebPushController::class,'subscribe'])->name('webpush.subscribe');
});
