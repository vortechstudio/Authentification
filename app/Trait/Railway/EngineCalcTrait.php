<?php

namespace App\Trait\Railway;

trait EngineCalcTrait
{
    use EngineTrait;

    public static function calcTarifAchat($type_train, $type_energy, $type_motor, $type_marchandise, $valEssieux, $nb_wagon = 1)
    {
        $train = match ($type_train) {
            'motrice' => 10000,
            'voiture' => 2500,
            'automotrice' => 20000,
            'bus' => 1000
        };

        $energy = match ($type_energy) {
            'vapeur' => 500,
            'diesel' => 1300,
            'electrique' => 3500,
            'hybride' => 4300,
            'none' => 0
        };

        if ($type_train == 'automotrice') {
            $wagon = 2500 * $nb_wagon;
        } else {
            $wagon = 0;
        }

        $calc = ($train + $energy + $wagon + $valEssieux) *
            self::selectorTypeTrain($type_train, 'coef') *
            self::selectorTypeEnergy($type_energy, 'coef') *
            self::selectorTypeMotor($type_motor, 'coef') *
            self::selectorTypeMarchandise($type_marchandise, 'coef');

        return $calc;
    }

    public static function calcPriceMaintenance($duration, $val_essieux)
    {
        $calc = $duration * $val_essieux;
        if ($calc >= 100) {
            return $calc / 10;
        } else {
            return $calc;
        }
    }

    public static function calcPriceLocation($price_achat)
    {
        return $price_achat / 30 / 1.2;
    }
}
