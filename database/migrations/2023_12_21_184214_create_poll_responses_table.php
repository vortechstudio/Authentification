<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('poll_responses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('count')->default(0);
            $table->json('users');

            $table->foreignId('poll_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('poll_responses');
    }
};
