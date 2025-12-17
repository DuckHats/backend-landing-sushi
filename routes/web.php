<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reservations/{token}/accept', [ReservationController::class, 'accept'])->name('reservations.accept');
Route::get('/reservations/{token}/reject', [ReservationController::class, 'reject'])->name('reservations.reject');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
