<?php

namespace App\Observer;

use App\Enum\UserServiceStatusEnum;
use App\Models\User;

/**
 * @codeCoverageIgnore
 */
class UserObserver
{
    public function created(User $user): void
    {

        $user->logs()->create([
            'action' => 'Création du compte',
            'user_id' => $user->id,
        ]);
        $user->services()->create([
            'status' => UserServiceStatusEnum::ACTIVE,
            'premium' => false,
            'user_id' => $user->id,
            'service_id' => 1,
        ]);

        $user->logs()->create([
            'action' => 'Liaison du compte au service principal',
            'user_id' => $user->id,
        ]);
        $user->services()->create([
            'status' => UserServiceStatusEnum::ACTIVE,
            'premium' => false,
            'user_id' => $user->id,
            'service_id' => 4,
        ]);
        $user->social()->create();

        $user->logs()->create([
            'action' => 'Liaison du compte a VortechLab',
            'user_id' => $user->id,
        ]);

        \Log::info('Création du compte: '.$user->name, [
            'user' => $user,
        ]);

    }

    public function sendingNotification($user, $notification)
    {
        if(!$user->optin) {
            return false;
        }
    }
}
