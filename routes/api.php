<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ReservationController;

use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/reservations', [ReservationController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:10,1']);

Route::post('/delivery-orders', [OrderController::class, 'store'])
    ->middleware(['auth:sanctum', 'throttle:10,1']);

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['status' => 'operational', 'database' => 'connected']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'database' => 'disconnected', 'error' => $e->getMessage()], 500);
    }
});
