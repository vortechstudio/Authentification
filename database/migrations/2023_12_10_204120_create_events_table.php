<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type_event', ["poll", "graphic"])->default("poll");
            $table->string('synopsis');
            $table->longText('content');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->enum('status', ['progress', 'submitting', 'evaluation', 'closed'])->default('progress');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
