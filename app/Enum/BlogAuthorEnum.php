<?php

namespace App\Enum;

enum BlogAuthorEnum: string
{
    case VortechStudio = 'VortechStudio';
    case RailwayManager = 'Railway Manager';

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
