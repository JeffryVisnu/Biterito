<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [MenuController::class, 'index']);
Route::get('/cart', [CartController::class, 'index']);
Route::post('/checkout', [OrderController::class, 'checkout']);
Route::get('/payment/check/{orderCode}', [OrderController::class, 'checkStatus']);
Route::get('/payment/{orderCode}', [OrderController::class, 'payment']);
Route::post('/webhook/midtrans', [OrderController::class, 'webhook']);
use App\Http\Controllers\AdminController;

Route::get('/admin/login', [AdminController::class, 'loginPage']);
Route::post('/admin/login', [AdminController::class, 'login'])->middleware('throttle:5,1');
Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('/admin/order/{id}', [AdminController::class, 'orderDetail']);
Route::post('/admin/logout', [AdminController::class, 'logout']);
Route::post('/admin/order/{id}/status', [AdminController::class, 'updateStatus']);