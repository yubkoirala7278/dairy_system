<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ======= Authentication Routes ===========
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// ======= Frontend Routes ===========
Route::name('frontend.')
    ->middleware(['auth', 'role:farmer'])
    ->group(function () {
        require __DIR__ . '/frontend.php';
    });

// ======= Admin Routes ===========
Route::middleware(['auth.admin', 'role:admin|dairy_manager|financial_manager'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        require __DIR__ . '/admin.php';
    });

// ======= Fallback Route ===========
Route::fallback(function () {
    return view('livewire.frontend.error.error-page');
});
