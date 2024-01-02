<?php

namespace App\Console\Commands\System;

use App\Models\Railway\Engine;
use App\Models\Railway\Gare;
use App\Models\Railway\Hub;
use App\Models\Railway\Ligne;
use App\Models\Railway\RailwayAdvantageCard;
use App\Service\SNCFService;
use App\Trait\Railway\GareTrait;
use Illuminate\Console\Command;
use function Laravel\Prompts\alert;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\intro;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\note;
use function Laravel\Prompts\outro;
use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class SystemCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create {action}';

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
            "gare" => $this->createGare(),
            "ligne" => $this->createLigne(),
            "cards" => $this->createCards(),
        };
    }

    /**
    * @codeCoverageIgnore
    */
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

        $calc_price_achat = Engine::calcTarifAchat(
            $type_train,
            $type_energy,
            $type_motor,
            $type_marchandise,
            Engine::getDataCalcForEssieux($essieux, $type_train == 'automotrice', $type_train == 'automotrice' ? $nb_wagon : 1),
            $nb_wagon
        );

        $calc_price_maintenance = \App\Models\Railway\Engine::calcPriceMaintenance(
            \App\Models\Railway\Engine::calcDurationMaintenance($essieux)->diffInMinutes(now()->startOfDay()),
            \App\Models\Railway\Engine::getDataCalcForEssieux($essieux, $type_train == 'automotrice', $type_train == 'automotrice' ? $nb_wagon : 1)
        );

        $calc_price_location = Engine::calcPriceLocation($calc_price_achat);

        \Laravel\Prompts\info("Création du matériel roulant");

        $duree_maintenance = Engine::calcDurationMaintenance($essieux, $type_train == 'automotrice', $type_train == 'automotrice' ? $nb_wagon : 1);
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

        $engine->tarif()->create([
            "price_achat" => $calc_price_achat,
            "price_maintenance" => $calc_price_maintenance,
            "price_location" => $calc_price_location,
            "engine_id" => $engine->id
        ]);


        alert("Installation terminer!");
        \Laravel\Prompts\info("Installer les images dans les dossiers correspondant.");
    }

    /**
    * @codeCoverageIgnore
    */
    private function createGare()
    {
        intro("Création d'une gare");

        $name = text(
            label: "Quel est le nom de la gare ?"
        );

        $type_gare = select(
            label: "Quel est le type de gare ?",
            options: ["halte", "small", "medium", "large", "terminus"]
        );

        $nb_quai = text(
            label: "Quel est le nombre de quai ?"
        );

        $transports = multiselect(
            label: "Selectionner les types de transport acceptées dans cette gare",
            options: ["ter", "tgv", "intercity", "tram", "bus", "metro"]
        );

        if($type_gare == "large" || $type_gare == "terminus") {
            $hub = confirm("Cette gare est-elle un hub ?");
        } else {
            $hub = false;
        }

        if($hub) {
            $visual = select(
                label: "Mode de production de ce matériel",
                options: ["beta", "prod"],
                hint: "Si prod est selectionner, le matériel est disponible en béta et en prod simultanément"
            );
            $active = confirm("Voulez-vous l'activer ?");
        } else {
            $visual = null;
            $active = false;
        }

        $sncf = new SNCFService();


        $gare = Gare::create([
            "uuid" => \Str::uuid(),
            "name" => $name,
            "type_gare" => $type_gare,
            "latitude" => $sncf->searchGare($name)['latitude'],
            "longitude" => $sncf->searchGare($name)['longitude'],
            "city" => $sncf->searchGare($name)['city'],
            "pays" => $sncf->searchGare($name)['pays'],
            "freq_base" => $sncf->searchFreq($name)['freq'],
            "habitant_city" => GareTrait::getHabitant($type_gare, $sncf->searchFreq($name)['freq']),
            "transports" => json_encode($transports),
            "equipements" => json_encode(Gare::defineEquipements($type_gare))
        ]);

        //TODO: Recherche de la météo initial

        if($active) {
            $gare->hub()->create([
                "price_base" => Gare::definePrice($type_gare, $nb_quai),
                "taxe_hub_price" => Gare::defineTaxeHub(Gare::definePrice($type_gare, $nb_quai), $nb_quai),
                "active" => $active,
                "visual" => $visual,
                "gare_id" => $gare->id
            ]);
        }
    }

    /**
    * @codeCoverageIgnore
    */
    private function createLigne()
    {
        intro("Création d'une ligne");
        note("Veillez à completer la ligne dans sa fiche à la fin de cette interface");

        $hub_id = select(
            label: "Quel est le hub affilier ?",
            options: $this->formatHubs(),
            scroll:100
        );

        $gare_depart = select(
            label: "Quel est la gare de départ ?",
            options: $this->formatGaresDepart($hub_id)
        );

        $gare_arrive = search(
            label: "Quel est la gare d'arrivée ?",
            options: fn (string $value) => strlen($value) > 0 ?
                $this->formatGare($value) :
                [],
            scroll: 10
        );

        $nb_station = text(
            label: "Combien de station comporte la ligne ?"
        );

        $type_ligne = \Laravel\Prompts\select(
            label: "Quel est le type de ligne ?",
            options: ["ter", "tgv", "intercite", "transilien", "tram", "metro", "bus"],
            default: "ter"
        );

        $visual = select(
            label: "Mode de production de cette ligne",
            options: ["beta", "prod"],
            hint: "Si prod est selectionner, le matériel est disponible en béta et en prod simultanément"
        );

        Ligne::create([
            "nb_station" => $nb_station,
            "price" => 0,
            "visual" => $visual,
            "type_ligne" => $type_ligne,
            "start_gare_id" => $gare_depart,
            "end_gare_id" => $gare_arrive,
            "hub_id" => $hub_id
        ]);

        alert("Ligne ajouté avec succès");

    }

    /**
    * @codeCoverageIgnore
    */
    private function formatHubs()
    {
        $hubs = Hub::where('active', true)->get();
        $hubs_array = [];
        foreach($hubs as $hub) {
            $hubs_array[$hub->id] = $hub->gare->name;
        }
        return $hubs_array;
    }

    /**
    * @codeCoverageIgnore
    */
    private function formatGare($value)
    {
        $gares = Gare::where('name', 'like', "%".$value."%")->get();
        $gares_array = [];
        foreach($gares as $gare) {
            $gares_array[$gare->id] = $gare->name;
        }
        return $gares_array;
    }

    /**
    * @codeCoverageIgnore
    */
    private function formatGaresDepart($hub_name)
    {
        $hub = Hub::find($hub_name);
        $gares = Gare::where('name', 'LIKE', "%".$hub_name."%")->get();
        return [$hub->gare->id => $hub->gare->name];
    }

    private function createCards()
    {
        RailwayAdvantageCard::generateAll();
    }
}
