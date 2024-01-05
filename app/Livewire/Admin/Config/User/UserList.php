<?php

namespace App\Livewire\Admin\Config\User;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class UserList extends Component
{
    use WithPagination,LivewireAlert;
    public string $search = '';
    public int $perPage = 25;
    public string $orderField = 'name';
    public string $orderDirection = 'ASC';
    protected array $queryString = [
        'search' => ['except' => ''],
        'orderField' => ['except' => 'name'],
        'orderDirection' => ['except' => 'ASC'],
    ];
    public function render()
    {
        return view('livewire.admin.config.user.user-list', [
            "users" => User::where('name', 'like', "%{$this->search}%")
                ->orderBy($this->orderField, $this->orderDirection)
                ->paginate($this->perPage)
        ])
            ->layout('components.layouts.admin');
    }

    /**
     * @codeCoverageIgnore
     */
    public function setOrderField(string $name): void
    {
        if($name === $this->orderField) {
            $this->orderDirection = $this->orderDirection === 'ASC' ? 'DESC' : "ASC";
        } else {
            $this->orderField = $name;
            $this->reset('orderDirection');
        }
    }

    public function logoutAllConfirm()
    {
        $this->confirm('Êtes-vous sûr de vouloir déconnecter tous les utilisateurs ?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'cancelButtonText' => 'Annuler',
            'onConfirmed' => 'logoutAll',
            'onCancelled' => 'cancelled'
        ]);
    }

    public function logoutAll()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        foreach ($users as $user) {
            $user->tokens()->delete();
        }
        $this->alert('success', 'Tous les utilisateurs ont été déconnectés avec succès');
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $user->notify(new UserDeleteNotification($user));
        $this->alert('success', 'L\'utilisateur à été supprimé avec succès');
    }
}
