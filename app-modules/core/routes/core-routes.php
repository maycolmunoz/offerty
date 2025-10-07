<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\HomeController;

Route::middleware('web')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('dashboard', [HomeController::class, 'dashboard'])
        ->middleware(['auth', 'verified'])->name('dashboard');
});
