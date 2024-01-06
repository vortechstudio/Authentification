<?php

namespace App\Livewire\Forms\Admin\Config\User;

use App\Models\User;
use App\Notifications\System\SendMessageNotification;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user;

    public $firstname = "";
    public $lastname = "";
    public $name = "";
    public $email = "";
    public $password = "";
    public $password_confirmation = "";

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }


    public function updateUser()
    {
        $this->validate([
            "name" => "required|string|max:255",
        ]);

        $this->user->update(
            $this->only("name")
        );
    }

    public function updateMail()
    {
        $this->validate([
            "email" => "required|string|email|max:255|unique:users,email," . $this->user->id,
        ]);

        $this->user->update(
            $this->only("email")
        );

        $this->user->notify(new SendMessageNotification(
        "Votre adresse email a été modifiée",
            "Votre adresse mail de contact à été modifier par un administrateur. Si vous n'êtes pas à l'origine de cette modification, veuillez contacter un administrateur.",
            "info",
            "fa-info-circle",
            route('account.app'),
        ));
        $this->user->sendEmailVerificationNotification();
    }

    public function updatePassword()
    {
        $status = Password::sendResetLink($this->only(['email']));

        if($status == Password::RESET_LINK_SENT) {
            return true;
        } else {
            return false;
        }
    }
}
