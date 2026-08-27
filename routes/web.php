<?php

use App\Http\Middleware\IsAdminMiddleware;
use App\Http\Middleware\IsUserMiddleware;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('admin')
        ->name('admin.')
        ->middleware(IsAdminMiddleware::class)
        ->group(function () {
            Route::resource('tasks', Admin\TaskController::class);
        });

    Route::prefix('user')
        ->name('user.')
        // ->middleware(IsUserMiddleware::class)
        ->group(function () {
            Route::resource('tasks', User\TaskController::class);
        });
});

require __DIR__.'/auth.php';
