<?php

namespace App\Livewire\Account;

use http\Client\Curl\User;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Livewire\Attributes\Title;
use Livewire\Component;

class App extends Component
{
    public bool $showSelectEditingForm = false;
    public bool $passwordForm = false;
    public bool $emailForm = false;
    public bool $deleteUserForm = false;
    public string $email, $password, $password_confirmation;
    #[Title('Information de compte')]
    public function render()
    {
        return view('livewire.account.app')->layout('components.layouts.app');
    }

    public function resetInputFiled()
    {
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function selectEditing()
    {
        $this->showSelectEditingForm = !$this->showSelectEditingForm;
    }

    public function selectEmailForm()
    {
        $this->emailForm = !$this->emailForm;
        $this->passwordForm = false;
        $this->deleteUserForm = false;
    }

    public function selectPasswordForm()
    {
        $this->passwordForm = !$this->passwordForm;
        $this->emailForm = false;
        $this->deleteUserForm = false;
    }

    public function selectDeleteUserForm()
    {
        $this->deleteUserForm = !$this->deleteUserForm;
        $this->emailForm = false;
        $this->passwordForm = false;
    }

    public function changeEmail()
    {
        $user = \App\Models\User::find(auth()->user()->id);
        $user->update([
            "email" => $this->email,
            "email_verified_at" => null
        ]);

        $user->notify(new SendEmailVerificationNotification());

        session()->flash('message', "L'adresse mail à été changer, veuillez consulter votre boite mail afin de valider cette nouvelle adresse !");
    }

    public function changePassword()
    {
        $this->validate([
            "password" => "required|min:8|confirmed"
        ]);
        $user = \App\Models\User::find(auth()->user()->id);
        $user->update([
            "password" => \Hash::make($this->password)
        ]);

        session()->flash('message', "Le mot de passe a été changer !");
        \Session::flush();
        \Auth::logout();

        $this->redirectRoute('login');
    }

    public function deleteUser()
    {
        $user = \App\Models\User::find(auth()->user()->id);
        $user->delete();
        \Session::flush();
        \Auth::logout();
        $this->redirectRoute('login');
    }
}
