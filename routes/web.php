<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test');
});

// Demo Auth Pages
Route::prefix('demo')->name('demo.')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');
    Route::get('/register', fn () => view('auth.register'))->name('register');
    Route::get('/forgot-password', fn () => view('auth.forgot-password'))->name('forgot-password');
    Route::get('/reset-password', fn () => view('auth.reset-password'))->name('reset-password');
    Route::get('/verify-email', fn () => view('auth.verify-email'))->name('verify-email');

    // Dashboard
    Route::get('/', fn () => view('pages.dashboard.index'))->name('dashboard');
    Route::get('/settings', fn () => view('pages.settings.index'))->name('settings');

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', fn () => view('pages.users.index'))->name('index');
        Route::get('/create', fn () => view('pages.users.form'))->name('create');
        Route::get('/{id}/edit', fn () => view('pages.users.form'))->name('edit');
        Route::get('/profile', fn () => view('pages.users.profile'))->name('profile');
    });
});
