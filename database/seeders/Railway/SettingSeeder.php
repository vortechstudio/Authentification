<?php

namespace Database\Seeders\Railway;

use App\Models\Railway\RailwaySetting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        if (! RailwaySetting::where('name', 'like', '%price_electricity%')->exists()) {
            RailwaySetting::create([
                'name' => 'price_electricity',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%price_diesel%')->exists()) {
            RailwaySetting::create([
                'name' => 'price_diesel',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%price_parking%')->exists()) {
            RailwaySetting::create([
                'name' => 'price_parking',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%price_kilometer%')->exists()) {
            RailwaySetting::create([
                'name' => 'price_kilometer',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%start_argent%')->exists()) {
            RailwaySetting::create([
                'name' => 'start_argent',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%price_tpoint%')->exists()) {
            RailwaySetting::create([
                'name' => 'price_tpoint',
                'value' => 0,
            ]);
        }

        if (! RailwaySetting::where('name', 'like', '%start_research%')->exists()) {
            RailwaySetting::create([
                'name' => 'start_research',
                'value' => 0,
            ]);
        }
    }
}
