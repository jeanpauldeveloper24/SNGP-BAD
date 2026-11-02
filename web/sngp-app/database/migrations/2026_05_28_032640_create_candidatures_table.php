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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            
            // Liaison directe avec le marché concerné (Clé étrangère)
            $table->foreignId('marche_id')->constrained('markets')->onDelete('cascade');
            
            // Identité du candidat
            $table->string('nom_candidat');
            $table->string('numero_registre_commerce');
            $table->string('email_candidat')->nullable()->comment('Email officiel de l\'entreprise pour les notifications');
            
            // --- Documents Administratifs Réglementaires (Chemins des fichiers PDF) ---
            $table->string('file_rccm')->nullable()->comment('Registre de Commerce et du Crédit Mobilier');
            $table->string('file_acte_constitution')->nullable()->comment('Acte légal de constitution (Statuts)');
            $table->string('file_dfe')->nullable()->comment('Déclaration Fiscale d\'Existence');
            $table->string('file_arf')->nullable()->comment('Attestation de Régularité Fiscale (Quitus)');
            $table->string('file_cnps')->nullable()->comment('Attestation CNPS à jour');
            $table->string('file_attestation_bancaire')->nullable()->comment('Attestation d\'ouverture de compte bancaire');
            
            // --- Proposition Financière ---
            $table->decimal('proposition_financiere', 15, 2); // Montant total proposé
            
            // --- Statuts et Évaluation (Double niveau de statut) ---
            $table->enum('statut_candidature', ['accepté', 'refusé'])->default('accepté')->comment('Phase d\'admissibilité administrative et technique');
            $table->enum('statut_marche', ['en attente', 'tributaire', 'rejeté'])->default('en attente')->comment('Phase d\'arbitrage final pour l\'attribution du marché');
            $table->text('motif_statut')->nullable(); // Raison ou détails de la décision d'évaluation ou du rejet
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};