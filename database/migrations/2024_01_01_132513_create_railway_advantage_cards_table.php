<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('railway_advantage_cards', function (Blueprint $table) {
            $table->id();
            $table->enum('class', ['premium', 'first', 'second', 'third']);
            $table->enum('type', ["argent", "research_rate", "research_coast", "audit_int", "audit_ext", "simulation", "credit_impot", "engine"]);
            $table->string('description');
            $table->bigInteger('qte');
            $table->integer('tpoint_cost');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_advantage_cards');
    }
};
