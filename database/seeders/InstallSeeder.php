<?php

namespace Database\Seeders;

use App\Enum\ServiceStatusEnum;
use App\Enum\ServiceTypeEnum;
use App\Models\Service;
use App\Models\Social\Cercle;
use App\Models\User;
use Database\Seeders\Railway\BadgeSeeder;
use Database\Seeders\Railway\BanqueSeeder;
use Database\Seeders\Railway\RentalSeeder;
use Database\Seeders\Railway\ResearchCategorySeeder;
use Database\Seeders\Railway\SettingSeeder;
use Database\Seeders\Social\CercleSeeder;
use Database\Seeders\Wiki\WikiCategorySeeder;
use Illuminate\Database\Seeder;

class InstallSeeder extends Seeder
{
    public function run(): void
    {

        Service::where('name', 'Accès de Base')->firstOrCreate([
            "name" => "Accès de Base",
            "type" => "plateforme",
            "description" => "Accès aux services de base",
            "page_content" => null,
            "status" => "production",
            "latest_version" => "1.0.0",
            "url_site" => "https://".config('app.domain'),
        ]);

        Service::where('name', 'Railway Manager')->firstOrCreate([
            "name" => "Railway Manager",
            "type" => "jeux",
            "description" => "Gérez votre empire ferrovaire !",
            "page_content" => null,
            "status" => "develop",
            "latest_version" => "0.4.0",
            "url_site" => "https://railway-manager.ovh",
        ]);

        Service::where('name', 'Railway Manager BETA')->firstOrCreate([
            "name" => "Railway Manager BETA",
            "type" => "jeux",
            "description" => "Gérez votre empire ferrovaire !",
            "page_content" => null,
            "status" => "develop",
            "latest_version" => "2023.1-BETA",
            "url_site" => "https://beta.railway-manager.ovh",
        ]);

        Service::where('name', 'Vortech Lab')->firstOrCreate([
            "name" => "Vortech Lab",
            "type" => "plateforme",
            "description" => "Plateforme Collaborative de Vortech Studio",
            "page_content" => null,
            "status" => null,
            "latest_version" => null,
            "url_site" => "https://lab.".config('app.domain'),
        ]);

        $this->call(CercleSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(RentalSeeder::class);
        $this->call(BadgeSeeder::class);
        $this->call(WikiCategorySeeder::class);
        $this->call(BanqueSeeder::class);
        $this->call(ResearchCategorySeeder::class);

        if(!User::where('email', "admin@".config('app.domain'))->exists()) {
            User::create([
                "name" => "Administrateur",
                "uuid" => \Str::uuid(),
                "email" => "admin@".config('app.domain'),
                "password" => \Hash::make("rbU89a-4"),
                "email_verified_at" => now(),
                "admin" => true,
            ]);
        }

    }
}
