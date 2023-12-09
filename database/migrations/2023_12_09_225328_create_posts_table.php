<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->enum('visibility', ["public", "friends"]);
            $table->boolean('anonymous');
            $table->boolean('commentable')->default(true);
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('user_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
