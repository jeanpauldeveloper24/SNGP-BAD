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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            
            // Traçabilité complète du règlement
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('project_module_id')->constrained('project_modules')->onDelete('cascade');
            $table->foreignId('market_id')->constrained('markets')->onDelete('cascade');
            
            // Identifiant du bénéficiaire externe (Rôle PRESTATAIRE sur Flutter/Firebase)
            $table->string('user_id_prestataire'); 
            
            // Informations financières
            $table->double('montant', 15, 2);
            $table->string('devise')->default('FCFA');
            $table->date('date_paiement')->nullable(); // Date effective du virement ou du chèque
            
            // États : Demandé, En cours, Effectué, Refusé
            $table->string('status')->default('Demandé');
            
            // Jalons administratifs (ex: 'Main-levée', 'Vérification aux impôts', 'Visa Contrôle', etc.)
            $table->string('etape_administrative')->default('Vérification aux impôts');
            
            // Numéros des pièces justificatives (Factures, quitus, ordre de virement...)
            $table->text('references')->nullable(); 
            
            // Traçabilité de l'initiateur du paiement (Comptable connecté sur Laravel)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};