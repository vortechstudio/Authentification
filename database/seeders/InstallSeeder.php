<?php

namespace Database\Seeders;

use App\Enum\ServiceStatusEnum;
use App\Enum\ServiceTypeEnum;
use App\Models\Service;
use Illuminate\Database\Seeder;

class InstallSeeder extends Seeder
{
    public function run(): void
    {

        Service::where('name', 'Railway Manager')->firstOrCreate([
            "name" => "Railway Manager",
            "type" => ServiceTypeEnum::GAME,
            "description" => "Gérez votre empire ferrovaire !",
            "page_content" => null,
            "status" => ServiceStatusEnum::DEVELOP,
            "latest_version" => "0.4.0",
            "url_site" => "https://railway-manager.ovh",
        ]);

        Service::where('name', 'Railway Manager BETA')->firstOrCreate([
            "name" => "Railway Manager BETA",
            "type" => ServiceTypeEnum::GAME,
            "description" => "Gérez votre empire ferrovaire !",
            "page_content" => null,
            "status" => ServiceStatusEnum::DEVELOP,
            "latest_version" => "2023.1-BETA",
            "url_site" => "https://beta.railway-manager.ovh",
        ]);

        Service::where('name', 'Vortech Lab')->firstOrCreate([
            "name" => "Vortech Lab",
            "type" => ServiceTypeEnum::PLATFORM,
            "description" => "Plateforme Collaborative de Vortech Studio",
            "page_content" => null,
            "status" => null,
            "latest_version" => null,
            "url_site" => "https://lab.".config('app.domain'),
        ]);

    }
}
