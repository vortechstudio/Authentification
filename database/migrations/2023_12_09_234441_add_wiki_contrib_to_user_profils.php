<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profils', function (Blueprint $table) {
            $table->boolean('wiki_contrib')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('user_profils', function (Blueprint $table) {
            $table->dropColumn('wiki_contrib');
        });
    }
};
