<?php

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Support\Facades\Route;
use Jira\Laravel\Facades\Jira;

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
    if (Auth::check()) {
        return redirect()->route('account.index');
    } else {
        return redirect()->route('login');
    }
})->name('home');

Route::get('/test', function () {
    $requestData = [
        "title" => "Erreur: Client error: `POST https://api.github.com/repos/vortechstudio/Authentification/issues` resulted in a `422 Unprocessable Entity`",
        "contexte" => [
            "route" => "https://auth.vortechstudio.test/login?provider=lab",
            "file" => "app/Exceptions/Handler.php",
            "line" => 34
        ]
    ];

    $describe = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
        "model" => "gpt-3.5-turbo",
        "messages" => [
            [
                "role" => "user",
                "content" => "Description sous le format issue de GITHUB: \n".$requestData["title"]."\n".$requestData["contexte"]["route"]."\n".$requestData["contexte"]["file"]."\n".$requestData["contexte"]["line"],
            ],
        ]
    ]);

    $reproduce = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
        "model" => "gpt-3.5-turbo",
        "messages" => [
            [
                "role" => "user",
                "content" => "Comment reproduire l'erreur: \n".$requestData["title"]."\n".$requestData["contexte"]["route"]."\n".$requestData["contexte"]["file"]."\n".$requestData["contexte"]["line"],
            ],
        ]
    ]);

    $comportement = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
        "model" => "gpt-3.5-turbo",
        "messages" => [
            [
                "role" => "user",
                "content" => "Comportement attendu: \n".$requestData["title"]."\n".$requestData["contexte"]["route"]."\n".$requestData["contexte"]["file"]."\n".$requestData["contexte"]["line"],
            ],
        ]
    ]);

    $solution = \OpenAI\Laravel\Facades\OpenAI::chat()->create([
        "model" => "gpt-3.5-turbo",
        "messages" => [
            [
                "role" => "user",
                "content" => "Solution proposé: \n".$requestData["title"]."\n".$requestData["contexte"]["route"]."\n".$requestData["contexte"]["file"]."\n".$requestData["contexte"]["line"],
            ],
        ]
    ]);

    dd($describe, $reproduce, $comportement, $solution);

    if($request->serverError()) {
        return response()->json([
            "error" => "Impossible de contacter l'API GPT-3"
        ], 500);
    } else {
        return response()->json([
            "message" => $request->json()
        ], 200);
    }
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

Route::prefix('account')->middleware(['web', 'verified', 'bannish'])->group(function () {
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
Route::post('/push', [\App\Http\Controllers\PushController::class, 'store']);
Route::get('/push', [\App\Http\Controllers\PushController::class, 'push']);
Route::get('/offline', \App\Livewire\IsOffline::class);

include 'admin.php';
