<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('lignes', function (Blueprint $table) {
            $table->id();
            $table->integer('nb_station');
            $table->decimal('price',16);
            $table->integer('distance')->default(0);
            $table->integer('time_min')->default(0);
            $table->boolean('active')->default(false);
            $table->enum('visual', ["beta", "prod"])->nullable();
            $table->enum('type_ligne', ["ter", "tgv", "intercite", "transilien", "tram", "metro", "bus"]);

            $table->foreignId('start_gare_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();

            $table->foreignId('end_gare_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();

            $table->foreignId('hub_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lignes');
    }
};
