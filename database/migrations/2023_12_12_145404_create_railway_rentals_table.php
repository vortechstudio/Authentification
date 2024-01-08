<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_rentals', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->integer('contract_duration')->comment('Durée exprimé en semaine');
            $table->json('type')->comment('Type de location (ter,tgv,intercity,tram,metro,bus)');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_rentals');
    }
};
