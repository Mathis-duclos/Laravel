<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ajout de la colonne admin dans la table users
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('admin')->default(0);
        });
    }

    /**
     * Suppression de la colonne admin si on rollback
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin');
        });
    }
};
