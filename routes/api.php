<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ReservationController;

use App\Http\Controllers\OrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/reservations', [ReservationController::class, 'store'])->middleware('throttle:10,1');
Route::post('/delivery-orders', [OrderController::class, 'store'])->middleware('throttle:10,1');
