<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_rewards', function (Blueprint $table) {
            $table->id();
            $table->string('reward_type');
            $table->integer('quantity');
            $table->enum('status', ['sending', 'pending', 'claiming'])->default('sending');
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('user_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();

            $table->foreignId('user_service_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_rewards');
    }
};
