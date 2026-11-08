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
        Schema::create('circonscriptions', function (Blueprint $table) {
            $table->id();
            // Clé étrangère auto-référencée pour la hiérarchie administrative (District/Région > Département > S/P > Commune)
            $table->foreignId('parent_id')->nullable()->constrained('circonscriptions')->onDelete('cascade');
            
            $table->enum('type', ['district_autonome', 'region', 'departement', 'sous_prefecture', 'commune']);
            $table->string('nom');
            $table->string('chef_lieu')->nullable(); // Ex: Agboville pour l'Agnéby-Tiassa
            $table->string('code_officiel')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('circonscriptions');
    }
};