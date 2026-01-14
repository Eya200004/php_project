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
        Schema::create('presences', function (Blueprint $table) {
            $table->id();

            $table->string('statut')->default('present');
            $table->dateTime('horaire');

            $table->foreignId('etudiant_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('seance_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // empêcher la double présence
            $table->unique(['etudiant_id', 'seance_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presences');
    }
};
