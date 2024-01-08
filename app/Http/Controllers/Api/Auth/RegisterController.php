<?php

namespace App\Http\Controllers\Api\Auth;

use App\Enum\UserServiceStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function __invoke()
    {
        $this->validate(request(), [
            'name' => ['required', 'min:2'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'max:255'],
        ]);

        $user = User::create([
            'name' => request()->get('name'),
            'email' => request()->get('email'),
            'password' => \Hash::make(request()->get('password')),
            'uuid' => \Str::uuid(),
        ]);

        $user->logs()->create([
            'action' => 'Création du compte',
            'user_id' => $user->id,
        ]);
        $user->services()->create([
            'status' => UserServiceStatusEnum::ACTIVE,
            'premium' => false,
            'user_id' => $user->id,
            'service_id' => 4,
        ]);
        $user->services()->create([
            'status' => UserServiceStatusEnum::ACTIVE,
            'premium' => false,
            'user_id' => $user->id,
            'service_id' => 1,
        ]);

        if (request()->get('provider') == 'railway') {
            $user->services()->create([
                'status' => UserServiceStatusEnum::ACTIVE,
                'premium' => false,
                'user_id' => $user->id,
                'service_id' => 2,
            ]);
        } elseif (request()->get('provider') == 'railway_beta') {
            $user->services()->create([
                'status' => UserServiceStatusEnum::ACTIVE,
                'premium' => false,
                'user_id' => $user->id,
                'service_id' => 3,
            ]);
        }

        event(new Registered($user));

        return response()->json([
            'success' => true,
        ]);
    }
}
