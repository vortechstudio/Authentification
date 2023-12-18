<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_services', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->boolean('premium')->default(false);
            $table->timestamps();

            $table->foreignId('user_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
            $table->foreignId('service_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_services');
    }
};
