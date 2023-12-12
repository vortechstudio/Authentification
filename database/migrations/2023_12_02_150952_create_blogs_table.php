<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('description')->nullable();
            $table->longText('contenue');
            $table->boolean('published');
            $table->timestamp('published_at')->nullable();
            $table->boolean('publish_to_social');
            $table->timestamp('publish_social_at')->nullable();
            $table->string('author');
            $table->boolean('promote')->default(false)->comment("Peut être mise en avant, Slideshow, etc...");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
