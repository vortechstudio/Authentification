<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_bonus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();

            $table->foreignId('railway_bonus_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();

            $table->dateTime('claimed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_bonus');
    }
};
