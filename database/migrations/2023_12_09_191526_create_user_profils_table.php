<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_profils', function (Blueprint $table) {
            $table->id();
            $table->string('header_img')->default('default.png');
            $table->string('profil_img')->default('default.png');
            $table->string('signature')->nullable();
            $table->integer('nb_posts')->default(0);
            $table->integer('nb_followeds')->default(0);
            $table->integer('nb_followers')->default(0);
            $table->integer('nb_likes')->default(0);
            $table->integer('nb_views')->default(0);

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
