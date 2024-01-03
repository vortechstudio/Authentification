<?php

namespace App\Models\Railway;

use App\Trait\Railway\DropRateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RailwayAdvantageCard extends Model
{
    use DropRateTrait,HasFactory;
    protected $guarded = [];
    protected $appends = ['class_color', 'type_icon', 'type_string'];

    public function getTypeIconAttribute()
    {
        return asset('/storage/icons/cards/' . $this->type . '.png');
    }

    public function getTypeStringAttribute()
    {
        return match ($this->type) {
            "argent" => "Argent",
            "research_rate" => "Taux R&D",
            "research_coast" => "Budget R&D",
            "audit_int" => "Audit interne",
            "audit_ext" => "Audit externe",
            "simulation" => "Simulation",
            "credit_impot" => "Crédit d'impôt",
            "engine" => "Matériels Roulants",
            "reskin" => "Reskin",
            default => "Erreur",
        };
    }

    public static function selectorClass()
    {
        $arr = collect();
        $arr->push([
            "id" => "third",
            "value" => "Troisième classe",
        ]);
        $arr->push([
            "id" => "second",
            "value" => "Seconde classe",
        ]);
        $arr->push([
            "id" => "first",
            "value" => "Première classe",
        ]);
        $arr->push([
            "id" => "premium",
            "value" => "Premium",
        ]);

        return $arr;
    }

    public static function selectorType()
    {
        $arr = collect();
        $arr->push([
            "id" => "argent",
            "value" => "Argent",
        ]);
        $arr->push([
            "id" => "research_rate",
            "value" => "Taux R&D",
        ]);
        $arr->push([
            "id" => "research_coast",
            "value" => "Budget R&D",
        ]);
        $arr->push([
            "id" => "audit_int",
            "value" => "Audit interne",
        ]);
        $arr->push([
            "id" => "audit_ext",
            "value" => "Audit externe",
        ]);
        $arr->push([
            "id" => "simulation",
            "value" => "Simulation",
        ]);
        $arr->push([
            "id" => "credit_impot",
            "value" => "Crédit d'impôt",
        ]);
        $arr->push([
            "id" => "engine",
            "value" => "Matériels Roulants",
        ]);
        $arr->push([
            "id" => "reskin",
            "value" => "Reskin",
        ]);

        return $arr;
    }
    public static function generateRandomType(): string
    {
        $types = ["argent", "research_rate", "research_coast", "audit_int", "audit_ext", "simulation", "credit_impot", "engine", "reskin"];
        return $types[array_rand($types)];
    }

    public static function generateRandomClass(): string
    {
        $classes = ['premium', 'first', 'second', 'third'];
        return $classes[array_rand($classes)];
    }

    public static function generateQteFromTypeAndClass(string $type, string $class): float|int
    {
        return match ($class) {
            "premium" => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 10),
            "first" => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 5),
            "second" => self::generateQteFromType($type) * ($type == 'engine' || $type == 'reskin' ? 1 : 2),
            "third" => self::generateQteFromType($type),
            default => 0,
        };
    }

    public static function generateQteFromType(string $type): float|int
    {
        return match ($type) {
            "argent", "credit_impot", "research_coast" => round(mt_rand(100000, 1000000), -3, PHP_ROUND_HALF_UP),
            "research_rate" => round(generateRandomFloat(0.05, 0.20), 2, PHP_ROUND_HALF_UP),
            "audit_int", "audit_ext", "simulation" => mt_rand(1, 10),
            "engine", "reskin" => 1,
            default => 0,
        };
    }

    public static function defineCoastFromClass(string $class): int
    {
        return match ($class) {
            "premium" => 50,
            "first" => 25,
            "second" => 15,
            default => 0,
        };
    }

    public function getClassColorAttribute()
    {
        return match ($this->class) {
            "premium" => "bg-yellow-500",
            "first" => "bg-green-500",
            "second" => "bg-blue-500",
            "third" => "bg-gray-500",
        };
    }

    public static function generateDescriptionFromType(string $type, int $qte)
    {
        if($type == 'engine' || $type == 'reskin') {
            $motor = Engine::all()->random();
        } else {
            $motor = null;
        }
        return match ($type) {
            "argent" => "+ " . number_format($qte, 0, ',', ' ') . " €",
            "research_rate" => "Taux R&D + " . $qte . "%",
            "research_coast" => "Budget R&D + " . number_format($qte, 0, ',', ' ') . " €",
            "audit_int" => number_format($qte, 0, ',', ' ') . " audit interne",
            "audit_ext" => number_format($qte, 0, ',', ' ') . " audit externe",
            "simulation" => number_format($qte, 0, ',', ' ') . " simulation",
            "credit_impot" => "Impôt - " . number_format($qte, 0, ',', ' ') . " €",
            "engine" => $motor->name,
            "reskin" => "Reskin de " . $motor->name,
            default => "Erreur",
        };
    }

    public function getRandomCardByClass()
    {
        $cards = RailwayAdvantageCard::where('class', $this->class)->get();
        $totalRate = $cards->sum('drop_rate');
        $randomPoint = mt_rand(0, $totalRate * 100) / 100;

        $currentPoint = 0;
        foreach ($cards as $card) {
            $currentPoint += $card->drop_rate;
            if ($currentPoint >= $randomPoint) {
                return $card;
            }
        }

        return $cards->first();
    }

    public static function calculateDropRateByType(int $qte, string $type): float
    {
        return match ($type) {
            "argent" => self::rateArgent($qte),
            "research_rate" => self::rateResearchRate($qte),
            "research_coast" => self::rateResearchCoast($qte),
            "audit_int" => self::rateAuditInt($qte),
            "audit_ext" => self::rateAuditExt($qte),
            "simulation" => self::rateSimulation($qte),
            "credit_impot" => self::rateCreditImpot($qte),
            "engine", "reskin" => 5.0,
            default => 0,
        };
    }

    public static function generateAll(): void
    {
        foreach (RailwayAdvantageCard::all() as $card) {
            $card->delete();
        }

        // TODO: ajouter la prise en charge de model_id pour les reskins lorsque le développement est terminer
        for ($i = 0; $i <= 250; $i++) {
            $class = RailwayAdvantageCard::generateRandomClass();
            $type = RailwayAdvantageCard::generateRandomType();
            $qte = RailwayAdvantageCard::generateQteFromTypeAndClass($type, $class);
            $coast = RailwayAdvantageCard::defineCoastFromClass($class);
            RailwayAdvantageCard::create([
                "class" => $class,
                "type" => $type,
                "description" => RailwayAdvantageCard::generateDescriptionFromType($type, $qte),
                "qte" => $qte,
                "tpoint_cost" => $coast,
                "drop_rate" => RailwayAdvantageCard::calculateDropRateByType($qte, $type),
            ]);
        }
    }
}
