<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;

Route::get('/', [MenuController::class, 'index']);
Route::get('/cart', [CartController::class, 'index']);
Route::post('/checkout', [OrderController::class, 'checkout']);
Route::get('/payment/{orderCode}', [OrderController::class, 'payment'])->name('payment');
Route::post('/payment/{orderCode}/upload-proof', [OrderController::class, 'uploadProof'])->name('payment.upload-proof');

Route::get('/admin/login', [AdminController::class, 'loginPage']);
Route::post('/admin/login', [AdminController::class, 'login'])->middleware('throttle:5,1');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/order/{id}', [AdminController::class, 'orderDetail']);
Route::post('/admin/logout', [AdminController::class, 'logout']);
Route::post('/admin/order/{id}/status', [AdminController::class, 'updateStatus']);
Route::post('/admin/order/{id}/payment-status', [AdminController::class, 'updatePaymentStatus']);
