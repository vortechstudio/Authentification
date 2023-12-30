<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('railway_badges', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('action');
            $table->integer('action_count');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_badges');
    }
};
