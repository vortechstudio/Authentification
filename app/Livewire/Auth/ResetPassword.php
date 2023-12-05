<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Title;
use Livewire\Component;

class ResetPassword extends Component
{
    public string $token, $email, $password, $password_confirmation;

    public function mount()
    {
        $this->token = request()->get('token');
    }

    public function resetPassword()
    {
        $this->validate([
            "token" => 'required',
            "email" => 'required|email',
            "password" => 'required|min:8|confirmed'
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => \Hash::make($password)
                ])->setRememberToken(\Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            session()->flash('message', "Votre mot de passe à été réinitialiser");
        } else {
            session()->flash('error', "Une erreur est survenue");
        }
    }

    #[Title('Réinitialisation du mot de passe')]
    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
