<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // ⚠️ SQLite ne permet pas DROP COLUMN directement → Laravel recrée la table
            // On supprime "image" et on ajoute "image_url"
            $table->dropColumn('image');
            $table->string('image_url')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('image_url');
            $table->string('image')->nullable();
        });
    }
};
