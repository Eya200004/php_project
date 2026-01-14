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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('nom'); // nom du module
            $table->foreignId('enseignant_id')->constrained()->cascadeOnDelete(); // relation avec enseignant
            $table->foreignId('filiere_id')->constrained()->cascadeOnDelete(); // relation avec filiere
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
