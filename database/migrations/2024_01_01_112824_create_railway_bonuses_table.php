<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('railway_bonuses', function (Blueprint $table) {
            $table->id();
            $table->integer('number_day');
            $table->string('designation');
            $table->enum('type', ["argent", "tpoint", "research", "simulation", "audit_int", "audit_ext"]);
            $table->bigInteger('qte');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_bonuses');
    }
};
