<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReservationController;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/reservations', [ReservationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:10,1']);

Route::post('/delivery-orders', [OrderController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:10,1']);

// Product endpoints
Route::get('/products', [ProductController::class, 'index'])
    ->middleware(['auth:sanctum']);

Route::get('/products/{id}', [ProductController::class, 'show'])
    ->middleware(['auth:sanctum']);

Route::get('/categories', [ProductController::class, 'categories'])
    ->middleware(['auth:sanctum']);

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'operational',
            'database' => 'connected',
            'message' => config('app_texts.ui.welcome.status_operational')
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'database' => 'disconnected',
            'error' => $e->getMessage(),
            'message' => config('app_texts.ui.welcome.status_unavailable')
        ], 500);
    }
});
