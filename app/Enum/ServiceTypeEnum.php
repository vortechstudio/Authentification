<?php

namespace App\Enum;

/**
 * @codeCoverageIgnore
 */
enum ServiceTypeEnum: string
{
    case GAME = 'Jeux';
    case PLATFORM = 'Plateforme';

    /**
     * @codeCoverageIgnore
     */
    public static function all()
    {
        return collect([
            'jeux' => 'Jeux',
            'plateforme' => 'Plateforme',
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function selector()
    {
        $arr = collect();
        foreach (self::all() as $k => $service) {
            $arr->push([
                'id' => $k,
                'value' => $service,
            ]);
        }

        return $arr;
    }
}
