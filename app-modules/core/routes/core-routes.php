<?php

use Estivenm0\Core\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('dashboard', [HomeController::class, 'dashboard'])
        ->middleware(['auth', 'verified'])->name('dashboard');
});
