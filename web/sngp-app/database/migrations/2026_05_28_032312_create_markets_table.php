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
        Schema::create('markets', function (Blueprint $table) {
            $table->id();
            $table->string('numero_reference')->nullable();
            $table->string('objet');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('project_module_id')->nullable()->constrained('project_modules')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('methode_passation')->nullable();
            $table->string('etape')->default('EXPRESSION_BESOIN');
            $table->string('status')->default('Non attribué');
            $table->decimal('besoin_financier', 15, 2)->default(0);
            $table->string('devise', 10)->default('USD');
            
            $table->date('candidature_start_date')->nullable();
            $table->date('candidature_end_date')->nullable();
            
            // Stockage JSON de la proposition technique / besoins matériels
            // Contient le tableau : [{"designation": "...", "quantite": "...", "specification": "..."}]
            $table->json('besoins_materiels')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('markets');
    }
};