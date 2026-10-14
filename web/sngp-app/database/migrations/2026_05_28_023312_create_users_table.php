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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID local auto-incrémenté pour SQLite (tu peux y stocker l'UID Firebase si string, ou garder l'ID standard pour la rapidité)
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password'); // Haché
            $table->string('locale')->default('fr'); // <-- Ajout de la langue par défaut (fr)
            $table->string('phone')->nullable();
            $table->longText('photo')->nullable(); // Stockage de l'image en chaîne Base64
            
            // Liaison Clé Étrangère avec la table roles
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            
            $table->string('status')->default('Actif'); // Actif / Inactif
            $table->timestamp('last_connection')->nullable();
            
            // Traçabilité : l'admin ayant créé ce compte (nullable pour les auto-inscriptions initiales)
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            
            $table->rememberToken();
            $table->timestamps(); // Gère create_at (created_at) et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};