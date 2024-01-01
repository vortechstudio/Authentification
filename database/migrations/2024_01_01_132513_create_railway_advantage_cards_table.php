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
            $table->enum('type', ["argent", "research_rate", "research_coast", "audit_int", "audit_ext", "simulation", "credit_impot", "engine", "reskin"]);
            $table->string('description');
            $table->decimal('qte', 20,2);
            $table->integer('tpoint_cost');
            $table->decimal('drop_rate', 5, 2);
            $table->bigInteger('model_id')->nullable()->unsigned();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_advantage_cards');
    }
};
