<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gare_weathers', function (Blueprint $table) {
            $table->id();
            $table->string('weather');
            $table->string('temperature');
            $table->string('icon_url');
            $table->dateTime('latest_update');

            $table->foreignId('gare_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gare_weathers');
    }
};
