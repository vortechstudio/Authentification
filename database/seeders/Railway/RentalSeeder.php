<?php

namespace Database\Seeders\Railway;

use App\Models\Railway\RailwayRental;
use Illuminate\Database\Seeder;

class RentalSeeder extends Seeder
{
    public function run(): void
    {
        if(!RailwayRental::where('name', 'like', '%LocaRail+%')->exists()) {
            RailwayRental::create([
                "name" => "LocaRail+",
                "contract_duration" => 8,
                "type" => json_encode(["ter", "tgv", "intercite", "other"]),
            ]);
        }

        if(!RailwayRental::where('name', 'like', '%RailRent%')->exists()) {
            RailwayRental::create([
                "name" => "RailRent",
                "contract_duration" => 3,
                "type" => json_encode(["ter", "tgv"]),
            ]);
        }
    }
}
