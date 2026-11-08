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
        Schema::create('travaux', function (Blueprint $table) {
            $table->id();
            
            // Datetime de la mise à jour sur le terrain
            $table->dateTime('datetime');
            
            // Traçabilité complète du suivi
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('project_module_id')->constrained('project_modules')->onDelete('cascade');
            $table->foreignId('market_id')->constrained('markets')->onDelete('cascade');
            
            // Auteur de la mise à jour (Rôle : PRESTATAIRE sur Flutter/Firebase)
            $table->string('user_id');
            
            // Commentaire technique sur l'évolution
            $table->text('texte');
            
            // Médias : Photos ou vidéos prouvant l'état des travaux (Base64)
            $table->longText('medias')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travaux');
    }
};