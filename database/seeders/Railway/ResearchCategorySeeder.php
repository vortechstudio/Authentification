<?php

namespace Database\Seeders\Railway;

use App\Models\Railway\ResearchCategory;
use Illuminate\Database\Seeder;

class ResearchCategorySeeder extends Seeder
{
    public function run(): void
    {
        if (! ResearchCategory::where('name', 'Hubs')->exists()) {
            ResearchCategory::create([
                'name' => 'Hubs',
                'description' => 'Améliorer la gestion des hubs',
            ]);
        }

        if (! ResearchCategory::where('name', 'Matériels Roulants')->exists()) {
            ResearchCategory::create([
                'name' => 'Matériels Roulants',
                'description' => 'Améliorer la gestion des Matériels Roulants',
            ]);
        }

        if (! ResearchCategory::where('name', 'Lignes')->exists()) {
            ResearchCategory::create([
                'name' => 'Lignes',
                'description' => 'Améliorer la gestion des lignes et du traffic sur vos infrastructures',
            ]);
        }

        if (! ResearchCategory::where('name', 'Service de location')->exists()) {
            ResearchCategory::create([
                'name' => 'Service de location',
                'description' => 'Améliorer la disponibilité et les avantages des services de location',
            ]);
        }

        if (! ResearchCategory::where('name', 'Service bancaire')->exists()) {
            ResearchCategory::create([
                'name' => 'Service bancaire',
                'description' => 'Améliorer la disponibilité et les avantages des services bancaire',
            ]);
        }
    }
}
