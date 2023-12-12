<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title');
            $table->longText('content');
            $table->boolean('published');
            $table->dateTime('published_at');
            $table->softDeletes();
            $table->timestamps();

            $table->foreignId('parent_id')
               ->nullable()
               ->constrained("cms")
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cms');
    }
};
