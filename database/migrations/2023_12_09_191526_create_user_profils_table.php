<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profils', function (Blueprint $table) {
            $table->id();
            $table->string('header_img');
            $table->string('profil_img');
            $table->string('signature');
            $table->integer('nb_posts');
            $table->integer('nb_followeds');
            $table->integer('nb_followers');
            $table->integer('nb_likes');
            $table->integer('nb_views');

            $table->foreignId('user_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profils');
    }
};
