<?php

namespace App\Console\Commands\System;

use App\Models\Railway\Engine;
use Illuminate\Console\Command;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\note;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class SystemCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:create {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Système de création interactive';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        match ($this->argument('action')) {
            "engine" => $this->createEngine(),
        };
    }

    private function createEngine()
    {
        intro($this->description);
        $name = text(
            label: 'Quel est le nom du matériel roulant ?',
            required: true
        );
        $type_train = select(
            label: "Quel est le type de matériel ?",
            options: ["motrice", "voiture", "automotrice", "bus"],
            required: true
        );
        $type_transport = select(
            label: "Quel est le type de transport ?",
            options: ["ter", "tgv", "intercity", "tram", "metro", "bus", "other"]
        );
        $type_energy = select(
            label: "Le matériel utilise quel energie pour fonctionner ?",
            options: ["vapeur", "diesel", "electrique", "hybride", "none"]
        );

        if($type_train == 'automotrice') {
            $nb_wagon = text(
                label: "Nombre de voiture comportant l'automotrice",
                hint: "Motrice comprise"
            );
        } else {
            $nb_wagon = 0;
        }

        \Laravel\Prompts\info("Information Technique du matériel roulant");
        $essieux = text(
            label: "Quel est le type d'essieux",
            required: true
        );

        $velocity = text(
            label: "Quel est la vitesse maximal de l'engin ?",
            required: true
        );

        $type_motor = select(
            label: "Quel est le type de motorisation",
            options: ["diesel", "electrique 1500V", "electrique 25000V", "electrique 1500V/25000V", "vapeur", "hybride", "autre"]
        );

        $type_marchandise = select(
            label: "Quel est le type de marchandise transporter",
            options: ["none", "passagers", "marchandises"]
        );

        if($type_motor != 'none') {
            $nb_marchandise = text(
                label: "Capacité de chargement"
            );
        } else {
            $nb_marchandise = 0;
        }

        \Laravel\Prompts\info("Information relative à la gestion");

        $active = confirm(
            label: "Ce matériel est-il actif ?",
            yes: "Oui",
            no: "Non",
        );

        $in_shop = confirm(
            label: "Ce matériel est-il disponible en boutique ?",
            yes: "Oui",
            no: "Non",
        );

        $in_game = confirm(
            label: "Ce matériel est-il disponible en jeux ?",
            yes: "Oui",
            no: "Non",
        );

        $visual = select(
            label: "Mode de production de ce matériel",
            options: ["beta", "prod"],
            hint: "Si prod est selectionner, le matériel est disponible en béta et en prod simultanément"
        );

        if($in_shop) {
            $money_shop = select(
                label: "Quel est le type de monnaie en boutique ?",
                options: ["tpoint", "argent", "euro"]
            );

            $price_shop = text(
                label: "Quel est le montant initial ?"
            );
        } else {
            $money_shop = null;
            $price_shop = null;
        }

        \Laravel\Prompts\info("Création du matériel roulant");

        $duree_maintenance = Engine::calcDurationMaintenance($essieux);
        $engine = Engine::create([
            "uuid" => \Str::uuid(),
            "name" => $name,
            "slug" => \Str::slug($name),
            "type_transport" => $type_transport,
            "type_train" => $type_train,
            "type_energy" => $type_energy,
            "active" => $active,
            "in_shop" => $in_shop,
            "in_game" => $in_game,
            "visual" => $visual,
            "price_shop" => $price_shop,
            "money_shop" => $money_shop,
            "duration_maintenance" => $duree_maintenance->format("H:i:s")
        ]);

        note("Création des informations techniques");

        $engine->technical()->create([
            "essieux" => $essieux,
            "velocity" => $velocity,
            "type_motor" => $type_motor,
            "type_marchandise" => $type_marchandise,
            "nb_marchandise" => $nb_marchandise,
            "nb_wagon" => $nb_wagon,
            "engine_id" => $engine->id
        ]);

        alert("Installation terminer!");
        \Laravel\Prompts\info("Installer les images dans les dossiers correspondant.");
    }
}
