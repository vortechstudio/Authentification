<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->id();
            $table->longText('text');
            $table->integer('like');
            $table->boolean('is_reject')->default(false);
            $table->string('is_reject_reason')->nullable();
            $table->timestamp('is_reject_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('post_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();

            $table->foreignId('user_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_comments');
    }
};
