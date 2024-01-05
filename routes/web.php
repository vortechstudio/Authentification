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
    if(Auth::check()) {
        return redirect()->route('account.index');
    } else {
        return redirect()->route('login');
    }
})->name('home');

Route::get('/test', function() {
    dd(auth()->user()->social);
});

Route::get('/login', \App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Auth\Register::class)->name('register');
Route::get('/email/verify', \App\Livewire\Auth\VerifyEmailNotice::class)->name('verification.notice');
Route::delete('/logout', \App\Http\Controllers\LogoutController::class)->name('logout');

Route::get('/forgot-password', \App\Livewire\Auth\ForgotPassword::class)
    ->name('password.request')
    ->middleware('guest');

Route::get('/reset-password', \App\Livewire\Auth\ResetPassword::class)
    ->name('password.reset')
    ->middleware('guest');

Route::get('/confirm-password', \App\Livewire\Auth\PasswordConfirmation::class)
    ->name('password.confirm');

Route::prefix('account')->middleware(['web', "verified", "bannish"])->group(function () {
   Route::get('/', \App\Livewire\Account\Start::class)->name('account.index');
   Route::get('/app', \App\Livewire\Account\App::class)
       ->name('account.app')
       ->middleware(['password.confirm']);
   Route::get('/history', \App\Livewire\Account\HistoryAccount::class)
       ->name('account.history');
   Route::get('/history/login', \App\Livewire\Account\HistoryLogin::class)
       ->name('account.history.login');

   Route::prefix('services')->group(function () {
       Route::get('/access', \App\Livewire\Service\AccessList::class)
           ->name('service.access');
       Route::get('/otp', \App\Livewire\Service\Otp::class)
           ->name('service.otp');
   });
});

Route::get('/log', function () {
    return redirect('/log-viewer');
})->name('log');

Route::get('/is-banish', \App\Livewire\IsBannishUser::class)->name('bannish');
Route::post('/push',[\App\Http\Controllers\PushController::class, 'store']);
Route::get('/push',[\App\Http\Controllers\PushController::class, 'push']);
Route::get('/offline',\App\Livewire\IsOffline::class);

include("admin.php");
