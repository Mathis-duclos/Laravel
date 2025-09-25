<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('annee_sortie')->nullable()->after('id');
            $table->string('plateforme')->nullable();
            $table->unsignedTinyInteger('note')->nullable(); // 1..10 (contrainte côté validation)
            $table->text('review')->nullable();
            $table->text('points_positifs')->nullable();
            $table->text('points_negatifs')->nullable();
            $table->string('auteur_review')->nullable();
        });
    }

    public function down(): void
    {
        // Comme tu veux garder les colonnes, on ne les supprime pas.
        // Tu peux même laisser vide :
        // Schema::table('articles', fn (Blueprint $table) => { ... });
    }
};
