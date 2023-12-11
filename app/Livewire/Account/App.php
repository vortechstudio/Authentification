<?php

namespace App\Livewire\Account;

use App\Jobs\Service\ResizeImage;
use App\Service\Image;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class App extends Component
{
    use WithFileUploads;
    public bool $showSelectEditingForm = false;
    public bool $passwordForm = false;
    public bool $emailForm = false;
    public bool $deleteUserForm = false;

    public bool $avatarForm = false;
    public string $email, $password, $password_confirmation;
    #[Validate('image|max:1024')]
    public $avatar;
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
        $this->avatarForm = false;
    }

    public function selectPasswordForm()
    {
        $this->passwordForm = !$this->passwordForm;
        $this->emailForm = false;
        $this->deleteUserForm = false;
        $this->avatarForm = false;
    }

    public function selectDeleteUserForm()
    {
        $this->deleteUserForm = !$this->deleteUserForm;
        $this->emailForm = false;
        $this->passwordForm = false;
        $this->avatarForm = false;
    }

    public function selectAvatarForm()
    {
        $this->avatarForm = !$this->avatarForm;
        $this->passwordForm = false;
        $this->emailForm = false;
        $this->deleteUserForm = false;
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

    public function changeAvatar()
    {
        $user = \App\Models\User::find(auth()->user()->id);
        $uploadedFile = $this->avatar;
        $uploadedFile->storeAs('avatars/', auth()->user()->id.'.'.$uploadedFile->getClientOriginalExtension(), 'public');
        $image = new Image(\Storage::disk('public')->path('/avatars/'.auth()->user()->id.'.'.$uploadedFile->getClientOriginalExtension()));
        $formats = [64,128,256,512,1024];
        dispatch(new ResizeImage($image, $formats));
        session()->flash('message', "Votre avatar a été changer !");

        $user->update([
            "avatar" => auth()->user()->id.'.'.$uploadedFile->getClientOriginalExtension().'.webp'
        ]);
    }
}
