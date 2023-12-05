<?php

namespace App\Livewire\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Title;
use Livewire\Component;

class Register extends Component
{
    use PasswordValidationRules;
    public string $firstname;
    public string $lastname;
    public string $name;
    public string $email;
    public string $password;

    public function register()
    {
        $this->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'name' => [],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)],
            'password' => ['required', 'max:255', 'min:8'],
        ]);

        $user = User::create([
            'name' => $this->name ? $this->name : $this->firstname.' '.$this->lastname,
            'email' => $this->email,
            'password' => \Hash::make($this->password),
        ]);
        $user->logs()->create([
            'action' => "Création du compte",
            "user_id" => $user->id
        ]);

        event(new SendEmailVerificationNotification());

        session()->flash('message', 'Votre compte à été créer avec succès');
        $this->resetInputFields();
    }

    #[Title('Inscription')]
    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.app');
    }

    private function resetInputFields(){
        $this->firstname = '';
        $this->lastname = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }
}
