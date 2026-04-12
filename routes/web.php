<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ======= Authentication Routes ===========
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);
Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// ======= Admin Routes ===========
Route::middleware(['auth.admin', 'role:admin|dairy_manager|financial_manager'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        require __DIR__ . '/admin.php';
    });
