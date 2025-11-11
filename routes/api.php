<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\HealthProfileController;
use App\Http\Controllers\Api\InventoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Rutas públicas (sin autenticación)
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});

// TEMPORAL: Sin autenticación para pruebas
Route::apiResource('categories', CategoryController::class);
Route::apiResource('products', ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('customers', CustomerController::class);

Route::get('health-profiles', [HealthProfileController::class, 'index']);
Route::post('health-profiles', [HealthProfileController::class, 'store']);
Route::get('health-profiles/{id}', [HealthProfileController::class, 'show']);
Route::put('health-profiles/{id}', [HealthProfileController::class, 'update']);
Route::delete('health-profiles/{id}', [HealthProfileController::class, 'destroy']);

Route::get('inventory', [InventoryController::class, 'index']);
Route::post('inventory', [InventoryController::class, 'store']);
Route::get('inventory/low-stock', [InventoryController::class, 'lowStock']);
Route::get('inventory/{id}', [InventoryController::class, 'show']);
Route::put('inventory/{id}', [InventoryController::class, 'update']);
Route::delete('inventory/{id}', [InventoryController::class, 'destroy']);

// Rutas protegidas (requieren autenticación JWT)
Route::middleware('auth:api')->group(function () {
    
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
    });
});