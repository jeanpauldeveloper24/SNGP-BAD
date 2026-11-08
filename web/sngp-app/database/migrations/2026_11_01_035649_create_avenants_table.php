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
        Schema::create('avenants', function (Blueprint $table) {
            $table->id();
            $table->string('code_avenant')->unique(); // ex: AVN-DAO-2026-001
            
            // Liaison avec le marché d'origine
            $table->foreignId('market_id')->constrained('markets')->onDelete('cascade');
            
            $table->string('motif'); // Raison de l'avenant (ex: "Suite sinistre alerte #12")
            $table->text('description_technique')->nullable();
            
            // Modifications financières (0.00 si aucun impact budgétaire)
            $table->double('montant_additionnel', 15, 2)->default(0.00);
            $table->string('devise')->default('FCFA');
            
            // Modifications de calendrier (en jours, null si aucun impact de temps)
            $table->integer('jours_supplementaires')->nullable();
            
            // États du circuit : 'Initié', 'Visé par Contrôle', 'Validé & Signé', 'Refusé'
            $table->string('status')->default('Initié');
            
            // Acteurs de la validation
            $table->string('user_id_prestataire_demandeur'); // Le prestataire Flutter/Firebase à l'origine
            $table->unsignedBigInteger('validated_by')->nullable(); // L'ordonnateur qui signe l'avenant
            $table->foreign('validated_by')->references('id')->on('users')->onDelete('set null');
            
            $table->date('date_signature')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avenants');
    }
};