<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('engine_technicals', function (Blueprint $table) {
            $table->id();
            $table->string('essieux')->comment('Calcul: multiplication lettre par chiffre Ex: BOBO (2*15*2*15 / 100)');
            $table->integer('velocity');
            $table->enum('type_motor', ['diesel', 'electrique 1500V', 'electrique 25000V', 'electrique 1500V/25000V', 'vapeur', 'hybride', 'autre']);
            $table->enum('type_marchandise', ['none', 'passagers', 'marchandises']);
            $table->integer('nb_marchandise')->nullable();
            $table->integer('nb_wagon')->nullable();

            $table->foreignId('engine_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engine_technicals');
    }
};
