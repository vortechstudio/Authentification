<?php

namespace Database\Seeders\Support;

use App\Models\Support\Ticket\TicketCategory;
use Illuminate\Database\Seeder;

class TicketCategorySeeder extends Seeder
{
    public function run(): void
    {
        TicketCategory::create([
            'service_id' => 1,
            'name' => 'Problème de connexion',
            'icon' => 'fa-wifi',
        ]);

        TicketCategory::create([
            'service_id' => 1,
            'name' => 'Problème de facturation',
            'icon' => 'fa-money-bill-wave',
        ]);

        TicketCategory::create([
            'service_id' => 1,
            'name' => 'Problème de paiement',
            'icon' => 'fa-credit-card',
        ]);

        TicketCategory::create([
            'service_id' => 1,
            'name' => 'Problème de fonctionnement',
            'icon' => 'fa-cogs',
        ]);

        TicketCategory::create([
            'service_id' => 1,
            'name' => 'Problème de sécurité',
            'icon' => 'fa-shield-alt',
        ]);

        TicketCategory::create([
            'service_id' => 2,
            'name' => 'Problème générale',
            'icon' => 'fa-cogs',
        ]);

        TicketCategory::create([
            'service_id' => 2,
            'name' => 'Problème de sécurité',
            'icon' => 'fa-shield-alt',
        ]);

        TicketCategory::create([
            'service_id' => 2,
            'name' => 'Problème de fonctionnement',
            'icon' => 'fa-cogs',
        ]);

        TicketCategory::create([
            'service_id' => 3,
            'name' => 'Problème générale',
            'icon' => 'fa-cogs',
        ]);

        TicketCategory::create([
            'service_id' => 3,
            'name' => 'Problème de sécurité',
            'icon' => 'fa-shield-alt',
        ]);

        TicketCategory::create([
            'service_id' => 3,
            'name' => 'Problème de fonctionnement',
            'icon' => 'fa-cogs',
        ]);

        TicketCategory::create([
            'service_id' => 4,
            'name' => 'Problème générale',
            'icon' => 'fa-cogs',
        ]);

        TicketCategory::create([
            'service_id' => 4,
            'name' => 'Problème de sécurité',
            'icon' => 'fa-shield-alt',
        ]);

        TicketCategory::create([
            'service_id' => 4,
            'name' => 'Problème de fonctionnement',
            'icon' => 'fa-cogs',
        ]);
    }
}
