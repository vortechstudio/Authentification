<?php

namespace App\Trait\Railway;

trait EngineTrait
{
    public static function calcDurationMaintenance($essieux, $automotrice = false, $nb_wagon = 1)
    {
        $min_init = 15;

        $calcEssieux = $min_init + self::getDataCalcForEssieux($essieux, $automotrice, $nb_wagon);

        return now()->startOfDay()->addMinutes($calcEssieux);
    }

    public static function getDataCalcForEssieux($essieux, $automotrice = false, $nb_wagon = 1)
    {
        $bogeys = str_split($essieux);
        $calc = 2;

        foreach ($bogeys as $bogey) {
            $calc *= match ($bogey) {
                'C' => 3,
                'D' => 4,
                'E' => 5,
                'F' => 6,
                'G' => 7,
                'H' => 8,
                'I' => 9,
                'J' => 10,
                'K' => 11,
                'L' => 12,
                'M' => 13,
                'N' => 14,
                'O' => 15,
                'P' => 16,
                'Q' => 17,
                'R' => 18,
                'S' => 19,
                'T' => 20,
                'U' => 21,
                'V' => 22,
                'W' => 23,
                'X' => 24,
                'Y' => 25,
                'Z' => 26,
                default => 2
            };
        }

        if ($automotrice) {
            return ($calc / 100) * $nb_wagon;
        } else {
            return $calc / 100;
        }

    }

    public static function selectorTypeTransport($search = null)
    {
        $arr = collect();
        $arr->push([
            'id' => 'ter',
            'value' => 'TER',
        ]);
        $arr->push([
            'id' => 'tgv',
            'value' => 'TGV',
        ]);
        $arr->push([
            'id' => 'intercity',
            'value' => 'Intercité / Interloire',
        ]);
        $arr->push([
            'id' => 'tram',
            'value' => 'Tram / Tram-Train',
        ]);
        $arr->push([
            'id' => 'metro',
            'value' => 'Métro',
        ]);
        $arr->push([
            'id' => 'bus',
            'value' => 'Bus',
        ]);
        $arr->push([
            'id' => 'other',
            'value' => 'Autre',
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()['value'];
        } else {
            return $arr;
        }
    }

    public static function selectorTypeTrain($search = null, $field = null)
    {
        $arr = collect();
        $arr->push([
            'id' => 'motrice',
            'value' => 'Motrice',
            'coef' => 1.8,
        ]);
        $arr->push([
            'id' => 'voiture',
            'value' => 'Voiture',
            'coef' => 1.5,
        ]);
        $arr->push([
            'id' => 'automotrice',
            'value' => 'Automotrice',
            'coef' => 2,
        ]);
        $arr->push([
            'id' => 'bus',
            'value' => 'Bus',
            'coef' => 1.2,
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $arr;
        }
    }

    public static function selectorTypeEnergy($search = null, $field = null)
    {
        $arr = collect();
        $arr->push([
            'id' => 'diesel',
            'value' => 'Diesel',
            'coef' => 1.5,
        ]);
        $arr->push([
            'id' => 'vapeur',
            'value' => 'Vapeur',
            'coef' => 1.2,
        ]);
        $arr->push([
            'id' => 'electrique',
            'value' => 'Electrique',
            'coef' => 2.2,
        ]);
        $arr->push([
            'id' => 'hybride',
            'value' => 'Hybride',
            'coef' => 2.5,
        ]);
        $arr->push([
            'id' => 'none',
            'value' => 'Aucun',
            'coef' => 1,
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $arr;
        }
    }

    public static function selectorMoneyShop($search = null)
    {
        $argc = collect();
        $argc->push([
            'id' => 'tpoint',
            'value' => 'T Point',
        ]);
        $argc->push([
            'id' => 'argent',
            'value' => 'Monnaie Virtuel',
        ]);
        $argc->push([
            'id' => 'euro',
            'value' => 'Monnaie Réel',
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()['value'];
        } else {
            return $argc;
        }
    }

    public static function selectorTypeMotor($search = null, $field = null)
    {
        $argc = collect();

        $argc->push([
            'id' => 'diesel',
            'value' => 'Diesel',
            'coef' => 1.5,
        ]);

        $argc->push([
            'id' => 'electrique 1500V',
            'value' => 'Electrique 1500V',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'electrique 25000V',
            'value' => 'Electrique 25Kv',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'electrique 1500V/25000V',
            'value' => 'Electrique 1500V/25Kv',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'vapeur',
            'value' => 'Vapeur',
            'coef' => 1.2,
        ]);

        $argc->push([
            'id' => 'hybride',
            'value' => 'Hybride',
            'coef' => 2.2,
        ]);

        $argc->push([
            'id' => 'autre',
            'value' => 'Autre',
            'coef' => 1,
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $argc;
        }
    }

    public static function selectorTypeMarchandise($search = null, $field = null)
    {
        $argc = collect();

        $argc->push([
            'id' => 'none',
            'value' => 'Aucun',
            'coef' => 1,
        ]);

        $argc->push([
            'id' => 'passagers',
            'value' => 'Passagers',
            'coef' => 1.5,
        ]);

        $argc->push([
            'id' => 'marchandises',
            'value' => 'Marchandises',
            'coef' => 1.2,
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $argc;
        }
    }
}
