<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id();
            $table->uuid()->default(Str::uuid());
            $table->string('name');
            $table->string('slug');
            $table->enum('type_transport', [
                'ter',
                'tgv',
                'intercity',
                'tram',
                'metro',
                'bus',
                'other',
            ]);
            $table->enum('type_train', [
                'motrice',
                'voiture',
                'automotrice',
                'bus',
            ]);
            $table->enum('type_energy', [
                'vapeur',
                'diesel',
                'electrique',
                'hybride',
                'none',
            ])->nullable();
            $table->time('duration_maintenance')->default('00:00:00');
            $table->string('image')->nullable();
            $table->boolean('active')->default(false);
            $table->boolean('in_shop')->default(false);
            $table->boolean('in_game')->default(true);
            $table->enum('visual', ['beta', 'prod'])->nullable();
            $table->string('price_shop')->nullable();
            $table->enum('money_shop', [
                'tpoint',
                'argent',
                'euro',
            ])->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
