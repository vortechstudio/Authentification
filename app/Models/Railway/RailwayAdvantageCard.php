<?php

namespace App\Models\Railway;

use Illuminate\Database\Eloquent\Model;

class RailwayAdvantageCard extends Model
{
    protected $guarded = [];

    public static function generateRandomType(): string
    {
        $types = ["argent", "research_rate", "research_coast", "audit_int", "audit_ext", "simulation", "credit_impot", "engine"];
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
            "premium" => self::generateQteFromType($type) * 10,
            "first" => self::generateQteFromType($type) * 5,
            "second" => self::generateQteFromType($type) * 2,
            "third" => self::generateQteFromType($type),
            default => 0,
        };
    }

    public static function generateQteFromType(string $type): float|int
    {
        return match ($type) {
            "argent", "credit_impot", "research_coast" => rand(100000, 1000000),
            "research_rate" => generateRandomFloat(0.05, 0.20),
            "audit_int", "audit_ext", "simulation" => rand(1, 10),
            "engine" => 1,
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

    public static function generateDescriptionFromType(string $type, int $qte)
    {
        if($type == 'engine') {
            $motor = Engine::all()->random();
        } else {
            $motor = null;
        }
        return match ($type) {
            "argent" => "+ " . number_format($qte, 0, ',', ' ') . " €",
            "research_rate" => "Taux R&D + " . number_format($qte, 0, ',', ' ') . "%",
            "research_coast" => "Budget R&D + " . number_format($qte, 0, ',', ' ') . " €",
            "audit_int" => number_format($qte, 0, ',', ' ') . " audit interne",
            "audit_ext" => number_format($qte, 0, ',', ' ') . " audit externe",
            "simulation" => number_format($qte, 0, ',', ' ') . " simulation",
            "credit_impot" => "Impôt - " . number_format($qte, 0, ',', ' ') . " €",
            "engine" => $motor->name,
            default => "Erreur",
        };
    }
}
