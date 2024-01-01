<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('research_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('coast_base');
            $table->bigInteger('duration_base')->default(0)->comment("à ajouter et convertire par carbon now start of day add minutes");

            $table->foreignId('research_category_id')
               ->constrained()
               ->cascadeOnUpdate()
               ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('research_projects');
    }
};
