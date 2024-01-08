<?php

namespace App\Enum;

/**
 * @codeCoverageIgnore
 */
enum BlogCategoryEnum: string
{
    case RAILWAY = 'Railway Manager';
    case VORTECH = 'Entreprise';

    /**
     * @codeCoverageIgnore
     */
    public static function all()
    {
        return collect([
            'railway' => 'Railway Manager',
            'vortech' => 'Vortech Studio',
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    public static function get($search)
    {
        return collect([
            'railway' => 'Railway Manager',
            'vortech' => 'Vortech Studio',
        ])->get($search);
    }
}
