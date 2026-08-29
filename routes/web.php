<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Routes for the application. All routes are prefixed with "demo" for
| the starter kit demo mode. In production, rename or restructure
| these routes as needed.
|
*/

// Component preview page
Route::get('/', fn () => view('test'));

/*
|--------------------------------------------------------------------------
| Authentication Routes (Guest)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/demo/login', [LoginController::class, 'showLoginForm'])
        ->name('demo.login');

    Route::post('/demo/login', [LoginController::class, 'login'])
        ->name('demo.login.store');

    Route::get('/demo/register', [RegisterController::class, 'showRegistrationForm'])
        ->name('demo.register');

    Route::post('/demo/register', [RegisterController::class, 'register'])
        ->name('demo.register.store');

    Route::get('/demo/forgot-password', [PasswordResetLinkController::class, 'showForgotPasswordForm'])
        ->name('demo.forgot-password');

    Route::post('/demo/forgot-password', [PasswordResetLinkController::class, 'sendResetLink'])
        ->name('demo.forgot-password.store');

    Route::get('/demo/reset-password/{token}', [NewPasswordController::class, 'showResetForm'])
        ->name('demo.password.reset');

    Route::post('/demo/reset-password', [NewPasswordController::class, 'reset'])
        ->name('demo.password.store');
});

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/
Route::get('/demo/verify-email', [VerifyEmailController::class, 'showVerificationForm'])
    ->middleware('auth')
    ->name('demo.verification.notice');

Route::get('/demo/verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['auth', 'signed'])
    ->name('demo.verification.verify');

Route::post('/demo/verify-email/resend', [VerifyEmailController::class, 'sendVerification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('demo.verification.send');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/demo/logout', [LoginController::class, 'logout'])
        ->name('demo.logout');

    // Dashboard
    Route::get('/demo', [DashboardController::class, 'index'])
        ->name('demo.dashboard');

    // Settings (static demo page)
    Route::get('/demo/settings', fn () => view('pages.settings.index'))
        ->name('demo.settings');

    // User Management
    Route::prefix('demo/users')->name('demo.users.')->group(function () {
        Route::get('/', fn () => view('pages.users.index'))->name('index');
        Route::get('/create', fn () => view('pages.users.form'))->name('create');
        Route::get('/{id}/edit', fn () => view('pages.users.form'))->name('edit');
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
