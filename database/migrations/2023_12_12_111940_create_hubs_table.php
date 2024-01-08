<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hubs', function (Blueprint $table) {
            $table->id();
            $table->decimal('price_base', 16);
            $table->decimal('taxe_hub_price', 16);
            $table->boolean('active')->default(false);
            $table->enum('visual', ['beta', 'prod'])->nullable();

            $table->foreignId('gare_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hubs');
    }
};
