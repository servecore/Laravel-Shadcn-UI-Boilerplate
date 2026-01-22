<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('test');
});


// Demo Auth Pages
Route::prefix('demo')->name('demo.')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('forgot-password');
    Route::get('/reset-password', fn() => view('auth.reset-password'))->name('reset-password');
    Route::get('/verify-email', fn() => view('auth.verify-email'))->name('verify-email');
    
    // Dashboard
    Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');
    Route::get('/profile', fn() => view('dashboard.profile'))->name('profile');
    Route::get('/settings', fn() => view('dashboard.settings'))->name('settings');
});

