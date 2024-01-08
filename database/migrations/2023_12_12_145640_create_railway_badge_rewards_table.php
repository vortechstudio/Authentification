<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('railway_badge_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('Type de récompense (Argent,Tpoint,engine,etc...');
            $table->string('value')->comment('Valeur de la récompense, (Si engine ou autre mettre le UUID');

            $table->foreignId('railway_badge_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_badge_rewards');
    }
};
