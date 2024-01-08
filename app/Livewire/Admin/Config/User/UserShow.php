<?php

namespace App\Livewire\Admin\Config\User;

use App\Livewire\Forms\Admin\Config\User\UserForm;
use App\Models\Service;
use App\Models\User;
use App\Models\UserRewards;
use App\Models\UserService;
use App\Notifications\System\SendMessageNotification;
use App\Notifications\User\BannedNotification;
use App\Notifications\User\UnbannedNotification;
use App\Notifications\User\UserDeleteNotification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

class UserShow extends Component
{
    use LivewireAlert, WithPagination;

    public User $user;

    public UserForm $form;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public int $service_id = 0;

    public string $reward_type = '';

    public int $quantity = 0;

    public $selectedService = null;

    public $rewardTypes = [];

    public int $startEditing = 0;

    public int $startReward = 0;

    public int $perPageFeed = 5;

    public function mount(int $id): void
    {
        $this->user = User::find($id);
        $this->form->setUser($this->user);
    }

    #[Title('')]
    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.admin.config.user.user-show', [
            'logs' => $this->user->logs()
                ->where('created_at', [now()->startOfDay(), now()->endOfDay()])
                ->get(),
            'activeServices' => $this->user->services()->where('status', 'active')
                ->paginate(5),
            'inactiveServices' => $this->user->services()->where('status', 'inactive')
                ->paginate(5),
            'contribs' => $this->user->wikis()
                ->orderBy('updated_at', 'desc')
                ->paginate(5),
            'feeds' => $this->user->posts()
                ->paginate($this->perPageFeed),
            'followers' => $this->user->following()
                ->paginate(5),
            'all_logs' => $this->user->logs()
                ->paginate(5),
        ])
            ->layout('components.layouts.admin');
    }

    public function loadMoreFeed(int $counter)
    {
        $this->perPageFeed += $counter;
    }

    public function startEditingFn(int $id): void
    {
        $this->startEditing = $id;
    }

    public function startRewardFn(int $id): void
    {
        $this->startReward = $id;
    }

    public function delete(): void
    {
        if ($this->user->id === auth()->id()) {
            $this->alert('error', 'Vous ne pouvez pas supprimer votre propre compte');

            return;
        } else {
            $user = User::find($this->user->id);
            if ($this->user->admin) {
                $this->alert('error', 'Vous ne pouvez pas supprimer un compte administrateur');

                return;
            } else {
                $this->user->delete();
                $this->user->notify(new UserDeleteNotification($this->user));
                $this->alert('success', 'Utilisateur supprimé avec succès');
            }
        }
    }

    public function updateUser(): void
    {
        $this->form->updateUser();
        $this->startEditing = 0;
        $this->alert('success', "Information de l'utilisateur mise à jour avec succès");
    }

    public function updateMail(): void
    {
        $this->form->updateMail();
        $this->startEditing = 0;
        $this->alert('success', "Information de l'utilisateur mise à jour avec succès");
    }

    public function updatePassword(): void
    {
        if ($this->form->updatePassword()) {
            $this->alert('success', "Mot de passe de l'utilisateur mis à jour avec succès");
        } else {
            $this->alert('error', 'Une erreur est survenue lors de la mise à jour du mot de passe');
        }
    }

    public function updateSelectedService($service_id): void
    {
        $service = UserService::find($service_id);
        $this->rewardTypes = Service::getRewardTypesFromService($service->service->name);
    }

    public function sendReward(): void
    {
        $this->validate([
            'service_id' => 'required|integer',
            'reward_type' => 'required|string',
            'quantity' => 'required|integer',
        ]);

        try {
            $service = UserService::find($this->service_id);
            UserRewards::sendReward($this->reward_type, $this->quantity, $service->id);
            $this->alert('success', 'Récompense envoyée avec succès');
        } catch (\Exception $e) {
            $this->alert('error', "Une erreur est survenue lors de l'envoi de la récompense");
        }
    }

    public function ban()
    {
        $this->user->social()->update([
            'banned' => true,
            'banned_at' => now(),
            'banned_for' => now()->addDays(7),
        ]);

        $this->user->notify(new BannedNotification(
            $this->user,
            'Votre compte a été banni pour une durée de 7 jours par un administrateur'
        ));

        $this->alert('success', 'Utilisateur banni avec succès');
    }

    public function unban()
    {
        $this->user->social()->update([
            'banned' => false,
            'banned_at' => null,
            'banned_for' => null,
        ]);

        $this->user->notify(new UnbannedNotification(
            $this->user,
        ));

        $this->alert('success', 'Utilisateur débanni avec succès');
    }

    public function reinitAvert()
    {
        $this->user->social()->update([
            'avertissement' => 0,
        ]);

        $this->user->notify(new SendMessageNotification(
            'Vos avertissements ont été réinitialisés',
            'Vos avertissements ont été réinitialisés par un administrateur',
            'success',
            'fa-check-circle'
        ));

        $this->alert('success', 'Avertissements réinitialisés avec succès');
    }

    public function setInactiveService(int $service_id)
    {
        $service = UserService::find($service_id);
        $service->update([
            'status' => 'inactive',
        ]);

        $service->user->notify(new SendMessageNotification(
            'Service désactivé',
            'Le service '.$service->service->name.' a été désactivé par un administrateur',
            'warning',
            'fa-exclamation-triangle'
        ));

        $this->alert('success', 'Service désactivé avec succès');
    }

    public function setActiveService(int $service_id)
    {
        $service = UserService::find($service_id);
        $service->update([
            'status' => 'active',
        ]);

        $service->user->notify(new SendMessageNotification(
            'Service activé',
            'Le service '.$service->service->name.' a été activé par un administrateur',
            'success',
            'fa-check-circle'
        ));

        $this->alert('success', 'Service activé avec succès');
    }
}
