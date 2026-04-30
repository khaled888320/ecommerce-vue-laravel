<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartItemController;

// Auth routes — publice
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Produse & Categorii — publice
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::get('/categories', [CategoryController::class, 'index']);

// Rute protejate — trebuie token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Coș
    Route::get('/cart', [CartItemController::class, 'index']);
    Route::post('/cart', [CartItemController::class, 'store']);
    Route::delete('/cart/{cartItem}', [CartItemController::class, 'destroy']);

    // Comenzi
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

    // Admin routes — protejate + admin only
Route::middleware(['auth:sanctum', 'is_admin'])->prefix('admin')->group(function () {
    // Produse
    Route::get('/products', [App\Http\Controllers\Admin\ProductController::class, 'index']);
    Route::post('/products', [App\Http\Controllers\Admin\ProductController::class, 'store']);
    Route::put('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'update']);
    Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductController::class, 'destroy']);

    // Categorii
    Route::get('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::post('/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
    Route::put('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [App\Http\Controllers\Admin\CategoryController::class, 'destroy']);
});


// Temporary admin setup - DELETE AFTER USE
Route::get('/setup-admin', function() {
    $user = App\Models\User::where('email', 'khaled@test.com')->first();
    $user->update(['is_admin' => true]);
    return response()->json(['message' => 'Done!']);
});
});