<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('engine_tarifs', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_achat', 16)->nullable();
            $table->boolean('in_reduction')->default(false);
            $table->integer('percent_reduction')->nullable();
            $table->decimal('price_maintenance')->nullable();
            $table->decimal('price_location')->nullable();
            $table->timestamps();

            $table->foreignId('engine_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_tarifs');
    }
};
