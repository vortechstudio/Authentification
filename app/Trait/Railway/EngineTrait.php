<?php

namespace App\Trait\Railway;

trait EngineTrait
{
    public static function calcDurationMaintenance($essieux)
    {
        $min_init = 15;

        $calcEssieux = $min_init + self::getDataCalcForEssieux($essieux);

        return now()->startOfDay()->addMinutes($calcEssieux);
    }

    public static function getDataCalcForEssieux($essieux)
    {
        $bogeys = str_split($essieux);
        $calc = 2;

        foreach ($bogeys as $bogey) {
            $calc *= match ($bogey) {
                "C" => 3,
                "D" => 4,
                "E" => 5,
                "F" => 6,
                "G" => 7,
                "H" => 8,
                "I" => 9,
                "J" => 10,
                "K" => 11,
                "L" => 12,
                "M" => 13,
                "N" => 14,
                "O" => 15,
                "P" => 16,
                "Q" => 17,
                "R" => 18,
                "S" => 19,
                "T" => 20,
                "U" => 21,
                "V" => 22,
                "W" => 23,
                "X" => 24,
                "Y" => 25,
                "Z" => 26,
                default => 2
            };
        }

        return $calc / 100;

    }

    public static function selectorTypeTransport()
    {
        $arr = collect();
        $arr->push([
            "id" => "ter",
            "value" => "TER"
        ]);
        $arr->push([
            "id" => "tgv",
            "value" => "TGV"
        ]);
        $arr->push([
            "id" => "intercity",
            "value" => "Intercité / Interloire"
        ]);
        $arr->push([
            "id" => "tram",
            "value" => "Tram / Tram-Train"
        ]);
        $arr->push([
            "id" => "metro",
            "value" => "Métro"
        ]);
        $arr->push([
            "id" => "bus",
            "value" => "Bus"
        ]);
        $arr->push([
            "id" => "other",
            "value" => "Autre"
        ]);
        return $arr;
    }

    public static function selectorTypeTrain()
    {
        $arr = collect();
        $arr->push([
            "id" => "motrice",
            "value" => "Motrice"
        ]);
        $arr->push([
            "id" => "voiture",
            "value" => "Voiture"
        ]);
        $arr->push([
            "id" => "automotrice",
            "value" => "Automotrice"
        ]);
        $arr->push([
            "id" => "bus",
            "value" => "Bus"
        ]);

        return $arr;
    }

    public static function selectorTypeEnergy()
    {
        $arr = collect();
        $arr->push([
            "id" => "diesel",
            "value" => "Diesel"
        ]);
        $arr->push([
            "id" => "vapeur",
            "value" => "Vapeur"
        ]);
        $arr->push([
            "id" => "electrique",
            "value" => "Electrique"
        ]);
        $arr->push([
            "id" => "hybride",
            "value" => "Hybride"
        ]);
        $arr->push([
            "id" => "none",
            "value" => "Aucun"
        ]);

        return $arr;
    }

    public static function selectorMoneyShop()
    {
        $argc = collect();
        $argc->push([
            "id" => "tpoint",
            "value" => "T Point"
        ]);
        $argc->push([
            "id" => "argent",
            "value" => "Monnaie Virtuel"
        ]);
        $argc->push([
            "id" => "euro",
            "value" => "Monnaie Réel"
        ]);

        return $argc;
    }

    public static function selectorTypeMotor()
    {
        $argc = collect();

        $argc->push([
            "id" => "diesel",
            "value" => "Diesel"
        ]);

        $argc->push([
            "id" => "electrique 1500V",
            "value" => "Electrique 1500V"
        ]);

        $argc->push([
            "id" => "electrique 25000V",
            "value" => "Electrique 25Kv"
        ]);

        $argc->push([
            "id" => "electrique 1500V/25000V",
            "value" => "Electrique 1500V/25Kv"
        ]);

        $argc->push([
            "id" => "vapeur",
            "value" => "Vapeur"
        ]);

        $argc->push([
            "id" => "hybride",
            "value" => "Hybride"
        ]);

        $argc->push([
            "id" => "autre",
            "value" => "Autre"
        ]);

        return $argc;
    }

    public static function selectorTypeMarchandise()
    {
        $argc = collect();

        $argc->push([
            "id" => "none",
            "value" => "Aucun"
        ]);

        $argc->push([
            "id" => "passagers",
            "value" => "Passagers"
        ]);

        $argc->push([
            "id" => "marchandises",
            "value" => "Marchandises"
        ]);

        return $argc;
    }
}
