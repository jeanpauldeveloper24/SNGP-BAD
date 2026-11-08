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
        Schema::create('pnd_piliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pnd_version_id')->constrained('pnd_versions')->onDelete('cascade');
            $table->integer('numero'); // ex: 1, 2, 3...
            $table->text('libelle');   // Description du pilier
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnd_piliers');
    }
};