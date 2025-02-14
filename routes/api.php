<?php

use App\Http\Controllers\Api\AuthController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes (tidak perlu login)
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected routes (perlu login)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes yang perlu authentication
    Route::post('auth/logout', [AuthController::class, 'logout']);
    
    // User route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Product routes
    Route::get('/products', [AuthController::class, 'products']);
    Route::get('/productsDetail/{products_id}', [AuthController::class, 'productsDetail']);
    Route::get('/Getcart', [AuthController::class, 'Getcart']);
    Route::post('/cart',[AuthController::class, 'cart']);
    Route::post('/cart/{cart_id}', [AuthController::class, 'updateCart']);
    Route::delete('/cart/{cart_id}',[AuthController::class, 'deletCart']);
    Route::get('/Order', [AuthController::class, 'Order']);
    Route::get('/Order/{order_id}',[AuthController::class, 'show']);
    Route::post('/orders/checkout', [AuthController::class, 'checkout']);
});