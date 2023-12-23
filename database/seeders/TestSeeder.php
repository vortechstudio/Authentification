<?php

namespace Database\Seeders;

use App\Enum\BlogAuthorEnum;
use App\Enum\BlogCategoryEnum;
use App\Enum\BlogSubcategoryEnum;
use App\Models\Blog;
use App\Models\Social\Cercle;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            "name" => "Administrateur",
            "email" => "contact@vortechstudio.fr",
            "password" => \Hash::make("password"),
            "admin" => true,
            "uuid" => \Str::uuid(),
            "email_verified_at" => now(),
        ]);

        foreach (range(1, 10) as $i) {
            User::factory()->create(["admin" => false, "uuid" => Str::uuid(), "email_verified_at" => now()]);
        }

        Blog::withoutEvents(function () {
            foreach (range(1, 10) as $i) {
                $selectedCategory = match (rand(0,1)) {
                    0 => "railway",
                    1 => "vortech"
                };

                $selectSub = match(rand(0,3)) {
                    0 => "auth",
                    1 => "news",
                    2 => "event",
                    3 => "notice"
                };

                if($selectedCategory == "railway") {
                    $author = "railway";
                } elseif ($selectedCategory == "vortech") {
                    $author = "vortech";
                }
                $blog = Blog::factory()->create([
                    "title" => "Article $i",
                    "category" => $selectedCategory,
                    "subcategory" => $selectSub,
                    "author" => $author,
                ]);

                if($selectedCategory == "railway") {
                    $cercle = Cercle::find(1);
                } elseif ($selectedCategory == "vortech") {
                    $cercle = Cercle::find(2);
                }
                $cercle->blogs()->attach($blog);
            }
        });
    }
}