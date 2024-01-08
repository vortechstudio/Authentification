<?php

namespace App\Trait\Railway;

trait DropRateTrait
{
    public static function rateArgent(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 0.05;
        $rate = $base_rate - (floor($qte / 5000) * $PerQte);

        return max($rate, 10.0);
    }

    public static function rateResearchRate(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 0.20;
        $rate = $base_rate - (floor($qte * 10) * ($PerQte * 10));

        return max($rate, 10.0);
    }

    public static function rateResearchCoast(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 0.05;
        $rate = $base_rate - (floor($qte / 5000) * $PerQte);

        return max($rate, 10.0);
    }

    public static function rateAuditInt(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 5.0;
        $rate = $base_rate - (floor($qte / 5) * $PerQte);

        return max($rate, 10.0);
    }

    public static function rateAuditExt(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 5.0;
        $rate = $base_rate - (floor($qte / 5) * $PerQte);

        return max($rate, 10.0);
    }

    public static function rateSimulation(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 5.0;
        $rate = $base_rate - (floor($qte / 5) * $PerQte);

        return max($rate, 10.0);
    }

    public static function rateCreditImpot(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 0.05;
        $rate = $base_rate - (floor($qte / 5000) * $PerQte);

        return max($rate, 10.0);
    }
}
