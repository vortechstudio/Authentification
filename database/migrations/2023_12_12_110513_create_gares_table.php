<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gares', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->default(Str::uuid());
            $table->string('name');
            $table->enum('type_gare', ['halte', 'small', 'medium', 'large', 'terminus']);
            $table->string('latitude');
            $table->string('longitude');
            $table->string('city');
            $table->string('pays');
            $table->string('freq_base');
            $table->string('habitant_city');
            $table->json('transports')->nullable()->comment('Liste des moyens de transport accessible dans la gare');
            $table->json('equipements')->nullable()->comment('Liste des équipements dans la gare (wifi, toilette, etc...)');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gares');
    }
};
