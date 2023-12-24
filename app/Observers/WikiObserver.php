<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Wiki\Wiki;
use App\Notifications\System\AlertStatusWikiNotification;

class WikiObserver
{
    public function created(Wiki $wiki)
    {
        $wiki->logs()->create([
            "text" => "Création de l'article",
            "wiki_id" => $wiki->id
        ]);

        if(!$wiki->contributors()->where('user_id', auth()->user()->id)->exists()) {
            $wiki->contributors()->attach(auth()->user()->id);
            $wiki->logs()->create([
                "text" => auth()->user()->name." à créer l'article",
                "wiki_id" => $wiki->id
            ]);
        }

        $this->Notify($wiki, "created");
    }

    public function updated(Wiki $wiki)
    {
        $wiki->logs()->create([
            "text" => "Mise à jour de l'article par ".auth()->user()->name,
            "wiki_id" => $wiki->id
        ]);

        if(!$wiki->contributors()->where('user_id', auth()->user()->id)->exists()) {
            $wiki->contributors()->attach(auth()->user()->id);
            $wiki->logs()->create([
                "text" => auth()->user()->name." fait partie des contributeur de cette article",
                "wiki_id" => $wiki->id
            ]);
        }

        $this->Notify($wiki, "updated");
    }

    private function Notify(Wiki $wiki, string $statement)
    {
        if($wiki->posted && $wiki->posted_at <= now()) {
            foreach (User::all() as $user) {
                $user->notify(new AlertStatusWikiNotification($wiki, $user, $statement));
            }
        }
    }
}
