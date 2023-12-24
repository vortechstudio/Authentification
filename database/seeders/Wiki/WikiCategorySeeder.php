<?php

namespace Database\Seeders\Wiki;

use App\Models\Wiki\WikiCategory;
use App\Models\Wiki\WikiSubcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WikiCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WikiCategory::where('name' , 'Matériel Roulant')->firstOrCreate([
            "name" => "Matériel Roulant",
            "icon" => "1.png",
            "cercle_id" => 1
        ]);

        WikiSubcategory::where('name', 'Motrice')->firstOrCreate([
            "name" => "Motrice",
            "wiki_category_id" => 1
        ]);

        WikiSubcategory::where('name', 'Voiture')->firstOrCreate([
            "name" => "Voiture",
            "wiki_category_id" => 1
        ]);

        WikiSubcategory::where('name', 'Automotrice')->firstOrCreate([
            "name" => "Automotrice",
            "wiki_category_id" => 1
        ]);
    }
}
