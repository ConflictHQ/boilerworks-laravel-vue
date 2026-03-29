<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('/status', function () {
    return response()->json([
        'status' => 'ok',
        'app' => config('app.name'),
        'laravel' => app()->version(),
        'php' => PHP_VERSION,
        'environment' => app()->environment(),
        'timestamp' => now()->toIso8601String(),
    ]);
})->name('status');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('items', ItemController::class);
    Route::resource('categories', CategoryController::class);
});
