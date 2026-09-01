<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SetupWizardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------|
| Web Routes
|--------------------------------------------------------------------------|
|
| The "setup" middleware redirects to /setup if setup is not complete.
| Setup wizard routes are excluded from this check.
|
*/

/*
|--------------------------------------------------------------------------|
| Setup Wizard Routes (Guest, no setup check)
|--------------------------------------------------------------------------|
*/
Route::middleware(['guest', 'setup'])->prefix('setup')->name('setup.')->group(function () {
    Route::get('/', [SetupWizardController::class, 'step1'])
        ->name('step1');

    Route::get('/step-2', [SetupWizardController::class, 'step2'])
        ->name('step2');

    Route::post('/step-2', [SetupWizardController::class, 'saveAppConfig'])
        ->name('save-app-config');

    Route::get('/step-3', [SetupWizardController::class, 'step3'])
        ->name('step3');

    Route::post('/step-3', [SetupWizardController::class, 'saveDatabaseConfig'])
        ->name('save-database');

    Route::post('/test-connection', [SetupWizardController::class, 'testConnection'])
        ->name('test-connection');

    Route::get('/step-4', [SetupWizardController::class, 'step4'])
        ->name('step4');

    Route::post('/complete', [SetupWizardController::class, 'complete'])
        ->name('complete');
});

/*
|--------------------------------------------------------------------------|
| Application Routes (with setup check)
|--------------------------------------------------------------------------|
*/
Route::middleware('setup')->group(function () {

    // Component preview page
    Route::get('/', fn () => view('test'));

    /*
    |--------------------------------------------------------------------------|
    | Authentication Routes (Guest)
    |--------------------------------------------------------------------------|
    */
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])
            ->name('login');

        Route::post('/login', [LoginController::class, 'login'])
            ->name('login.store');

        Route::get('/register', [RegisterController::class, 'showRegistrationForm'])
            ->name('register');

        Route::post('/register', [RegisterController::class, 'register'])
            ->name('register.store');

        Route::get('/register/{token}', [RegisterController::class, 'showCompletionForm'])
            ->name('register.complete');

        Route::post('/register/{token}', [RegisterController::class, 'complete'])
            ->name('register.complete.store');

        Route::get('/forgot-password', [PasswordResetLinkController::class, 'showForgotPasswordForm'])
            ->name('forgot-password');

        Route::post('/forgot-password', [PasswordResetLinkController::class, 'sendResetLink'])
            ->name('forgot-password.store');

        Route::get('/reset-password/{token}', [NewPasswordController::class, 'showResetForm'])
            ->name('password.reset');

        Route::post('/reset-password', [NewPasswordController::class, 'reset'])
            ->name('password.store');
    });

    /*
    |--------------------------------------------------------------------------|
    | Email Verification Routes
    |--------------------------------------------------------------------------|
    */
    Route::get('/verify-email', [VerifyEmailController::class, 'showVerificationForm'])
        ->middleware('auth')
        ->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, 'verify'])
        ->middleware(['auth', 'signed'])
        ->name('verification.verify');

    Route::post('/verify-email/resend', [VerifyEmailController::class, 'sendVerification'])
        ->middleware(['auth', 'throttle:6,1'])
        ->name('verification.send');

    /*
    |--------------------------------------------------------------------------|
    | Authenticated Routes
    |--------------------------------------------------------------------------|
    */
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [LoginController::class, 'logout'])
            ->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        Route::get('/settings', [SettingsController::class, 'index'])
            ->name('settings');

        Route::put('/settings', [SettingsController::class, 'update'])
            ->name('settings.update');

        Route::prefix('users')->name('users.')->group(function () {
            Route::middleware('permission:manage users')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
                Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('/{user}', [UserController::class, 'update'])->name('update');
                Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            });

            Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
            Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        });
    });

});
