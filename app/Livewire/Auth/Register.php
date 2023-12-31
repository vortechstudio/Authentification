<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

class Register extends Component
{
    use LivewireAlert;

    public string $firstname = '';

    public string $lastname = '';

    public string $name = '';

    public string $email = '';

    public string $password = '';

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
            'uuid' => \Str::uuid(),
        ]);

        event(new Registered($user));

        $this->alert('success', 'Inscription reussie');
        $this->resetInputFields();
    }

    #[Title('Inscription')]
    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.app');
    }

    private function resetInputFields()
    {
        $this->firstname = '';
        $this->lastname = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }
}
