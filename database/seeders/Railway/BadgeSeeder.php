<?php

namespace Database\Seeders\Railway;

use App\Models\Railway\RailwayBadge;
use App\Models\Railway\RailwayBadgeReward;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        if(!RailwayBadge::where('name', 'like', '%Bienvenue%')->exists()) {
            RailwayBadge::create([
                "name" => "Bienvenue",
                "action" => "welcome",
                "action_count" => 1
            ]);
            RailwayBadgeReward::create([
                "railway_badge_id" => 1,
                "type" => "argent",
                "value" => 50000
            ])->create([
                "railway_badge_id" => 1,
                "type" => "tpoint",
                "value" => 10
            ]);
        }
    }
}
