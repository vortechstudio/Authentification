<?php

namespace Database\Seeders\Railway;

use App\Models\Railway\RailwayBanque;
use Illuminate\Database\Seeder;

class BanqueSeeder extends Seeder
{
    public function run(): void
    {
        if (! RailwayBanque::where('name', 'like', '%Minibank%')->exists()) {
            RailwayBanque::create([
                'name' => 'Minibank',
                'uuid' => \Str::uuid(),
                'description' => 'Banque proposant des mini-pret à interet très bas',
                'minimal_interest' => 1,
                'maximal_interest' => 4,
                'maximal_account_express_base' => 300000,
                'maximal_account_public_base' => 350000,
            ]);
        }

        if (! RailwayBanque::where('name', 'like', '%Volture Bank%')->exists()) {
            RailwayBanque::create([
                'name' => 'Volture Bank',
                'uuid' => \Str::uuid(),
                'description' => 'Banque proposant des pret interessant à interet fluctuant',
                'minimal_interest' => 1,
                'maximal_interest' => 8,
                'maximal_account_express_base' => 350000,
                'maximal_account_public_base' => 420000,
            ]);
        }

        if (! RailwayBanque::where('name', 'like', '%Rail Crédit%')->exists()) {
            RailwayBanque::create([
                'name' => 'Rail Crédit',
                'uuid' => \Str::uuid(),
                'description' => 'Emprunter sans retard ni conditions',
                'minimal_interest' => 4,
                'maximal_interest' => 8,
                'maximal_account_express_base' => 500000,
                'maximal_account_public_base' => 650000,
            ]);
        }

        if (! RailwayBanque::where('name', 'like', '%Bank-o%')->exists()) {
            RailwayBanque::create([
                'name' => 'Bank-o',
                'uuid' => \Str::uuid(),
                'description' => 'Avec Bank-o, les concurrent son KO',
                'minimal_interest' => 5,
                'maximal_interest' => 12,
                'maximal_account_express_base' => 750000,
                'maximal_account_public_base' => 900000,
            ]);
        }

        if (! RailwayBanque::where('name', 'like', '%CBIB%')->exists()) {
            RailwayBanque::create([
                'name' => 'CBIB',
                'uuid' => \Str::uuid(),
                'description' => "La Cash Brother International Bank propose des prêts volumineux à fort taux d'intérêt",
                'minimal_interest' => 7,
                'maximal_interest' => 15,
                'maximal_account_express_base' => 1000000,
                'maximal_account_public_base' => 10000000,
            ]);
        }

    }
}
