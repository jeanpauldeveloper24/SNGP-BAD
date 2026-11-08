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
        Schema::create('pnd_versions', function (Blueprint $table) {
            $table->id();
            $table->string('version'); // ex: "PND 2026-2030"
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('nombre_pilier')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pnd_versions');
    }
};