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
        Schema::create('alertes', function (Blueprint $table) {
            $table->id();
            
            // Émetteur du signalement (Rôle : PRESTATAIRE sur Flutter/Firebase)
            // Nullable car les alertes automatiques du système n'ont pas d'émetteur physique
            $table->string('user_id_prestataire')->nullable(); 
            
            // Type : anomalie, automatique, manuelle
            $table->string('type'); 
            
            // Niveau : faible, moyen, élevé, extreme
            $table->string('niveau')->default('moyen'); 
            
            $table->string('title'); // Objet de l'urgence
            $table->text('texte'); // Description détaillée du problème
            
            // Média : Photo du blocage ou du sinistre stockée au format texte (Base64)
            $table->longText('media')->nullable(); 
            
            // Liaisons optionnelles de contexte pour savoir d'où vient le problème
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('market_id')->nullable()->constrained('markets')->onDelete('cascade');
            
            // Suivi de l'administration (ex: 'En attente', 'Pris en compte', 'Résolu')
            $table->string('status')->default('En attente');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alertes');
    }
};