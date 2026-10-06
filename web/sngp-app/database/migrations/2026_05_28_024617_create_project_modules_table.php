<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Exécuter la migration.
     */
    public function up(): void
    {
        Schema::create('project_modules', function (Blueprint $table) {
            $table->id();
            
            // Relation avec le projet parent
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->onDelete('cascade');

            // Informations de repérage et description
            $table->integer('number'); // Numéro ou ordre du module/composante (ex: 1, 2, 3)
            $table->string('description');
            
            // Gestion financière du module
            $table->decimal('besoin_financier', 15, 2)->default(0.00);
            $table->string('devise', 10)->default('FCFA');
            
            // Planning / Durée & Statut
            $table->string('duree')->nullable(); // Ex: "6 mois", "Q1-Q3 2026"
            $table->string('status')->default('Actif');
            
            $table->timestamps();
        });
    }

    /**
     * Annuler la migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_modules');
    }
};