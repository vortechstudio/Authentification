<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('railway_banques', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('name');
            $table->string('description');
            $table->integer('minimal_interest');
            $table->integer('maximal_interest');
            $table->bigInteger('maximal_account_express_base');
            $table->bigInteger('maximal_account_public_base');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('railway_banques');
    }
};
