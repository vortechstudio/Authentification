<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ["jeux", 'plateforme']);
            $table->string('description');
            $table->longText('page_content')->nullable();
            $table->enum('status', ['idea', 'develop', 'production'])->nullable();
            $table->string('latest_version')->nullable();
            $table->string('url_site')->nullable();
            $table->string('cercle_reference')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
