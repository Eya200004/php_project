<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('filieres', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // nom de la filière
            $table->integer('semester'); // semestre
            $table->string('annee_universitaire'); // ex: 2025/2026
            $table->foreignId('departement_id')->constrained()->cascadeOnDelete(); // relation avec departement
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('filieres');
    }
};
