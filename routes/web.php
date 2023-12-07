<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
Route::get('/email/verify', \App\Livewire\Auth\VerifyEmailNotice::class)->name('verification.notice');

Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)
    ->name('password.request')
    ->middleware('guest');

Route::get('/reset-password', \App\Livewire\Auth\ResetPassword::class)
    ->name('password.reset')
    ->middleware('guest');

Route::get('/confirm-password', \App\Livewire\Auth\PasswordConfirmation::class)
    ->name('password.confirm');

Route::prefix('account')->middleware(['web', "verified"])->group(function () {
   Route::get('/', \App\Livewire\Account\Start::class)->name('account.index');
   Route::get('/app', \App\Livewire\Account\App::class)
       ->name('account.app')
       ->middleware(['password.confirm']);
});
