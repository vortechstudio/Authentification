<?php

namespace Database\Seeders\Social;

use App\Models\Social\Cercle;
use Illuminate\Database\Seeder;

class CercleSeeder extends Seeder
{
    public function run(): void
    {
        if(!Cercle::where('name', 'like', '%Railway Manager%')->exists()) {
            Cercle::create([
                'name' => 'Railway Manager',
            ]);
        }

        if(!Cercle::where('name', 'like', '%VortechLab%')->exists()) {
            Cercle::create([
                'name' => 'VortechLab',
            ]);
        }
    }
}
