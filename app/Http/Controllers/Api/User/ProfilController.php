<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ResponseApiController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\User\AvertissementNotification;
use App\Notifications\User\BannedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Log;

class ProfilController extends ResponseApiController
{
    public function index(Request $request)
    {
        $user = collect();
        if ($request->has('user_uuid')) {
            $info = User::where('uuid', $request->get('user_uuid'))
                ->first()
                ->load('logs', 'services', 'social', 'notifications', 'unreadNotifications', 'followers', 'following', 'blockeds');
            $user->put('info', $info);
            $user->put('posts', $info->posts()->with('cercles', 'tags', 'comments', 'likes')->get());
            $user->put('comments', $info->comments()->with('post')->get());
            $user->put('events', $info->events()->with('cercles', 'poll')->get());
        } else {
            $user = auth()->user();
        }

        return response()->json([
            'status' => "success",
            'user' => $user,
        ]);
    }

    public function updateProfil(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid')[0])->first();

        $user->update([
            'name' => $request->get('name'),
            'signature' => $request->get('signature'),
            'profil_img' => $request->get('profil_img'),
            'header_img' => $request->get('header_img'),
        ]);

        $user->logs()->create([
            "action" => "Mise à jour du profil sur Vortech Lab"
        ]);

        return $this->success();
    }

    public function updateStatus(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid')[0])->first();

        $user->update([
            'status' => $request->get('status'),
        ]);

        return $this->success(["user" => $user]);
    }

    public function avertissement(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid')[0])->first();
        if($user->social->avertissement > 3) {
            $user->social->update([
                "banned" => true,
                "banned_at" => now(),
                "banned_for" => now()->addDays(7)->startOfDay(),
            ]);

            $user->notify(new BannedNotification($user, "Votre compte a été banni pour une durée de 7 jours"));

            $user->logs()->create([
                'action' => 'Banissement du compte pour une durée de 7 jours',
                'user_id' => $user->id,
            ]);
        } else {
            $user->social->update([
                "avertissement" => $user->social->avertissement + 1,
            ]);

            $user->notify(new AvertissementNotification(
                $user,
                "Non respect des règles éthiques d'utilisations du service Vortech Lab"
            ));

            $user->logs()->create([
                'action' => "Avertissement pour non respect des conditions d'utilisations de Vortech Lab",
                'user_id' => $user->id,
            ]);
        }

        return $this->success();
    }

    public function updateOptin(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid')[0])->first();

        try {
            $user->social->update([
                'optin' => $request->get('optin'),
            ]);

            return $this->success();
        }catch (\Exception $e) {
            return $this->error($e, "Erreur lors de la mise à jour des paramètres");
        }
    }

    public function updateNotifin(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid')[0])->first();

        try {
            $user->social->update([
                'notifin' => $request->get('notifin'),
            ]);

            return $this->success();
        }catch (\Exception $e) {
            return $this->error($e, "Erreur lors de la mise à jour des paramètres");
        }

    }

    public function logout(Request $request)
    {
        Auth::logout();
        \Session::flush();

        return $this->success();
    }

    public function uban(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid')[0])->first();
        try {
            $user->blockeds()->detach($request->get('user_blocked_id'));
        }catch (\Exception $e) {
            return $this->error($e, "Erreur lors de la mise à jour des paramètres");
        }

        return $this->success();
    }

    public function ban(Request $request)
    {
        $user = User::where('uuid', $request->get('user_uuid')[0])->first();
        try {
            $user->blockeds()->attach($request->get('user_blocked_id'));
        }catch (\Exception $e) {
            return $this->error($e, "Erreur lors de la mise à jour des paramètres");
        }

        return $this->success();
    }
}
