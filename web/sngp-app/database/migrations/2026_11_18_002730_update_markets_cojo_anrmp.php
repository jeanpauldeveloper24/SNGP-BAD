<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            // Traçabilité des deux sous-comités de la COJO (Stockage JSON structuré)
            // Format attendu : {"president": "...", "secretaire": "...", "membres": ["...", "..."]}
            $table->json('comite_depouillement')->nullable()->after('methode_passation');
            $table->json('comite_analyse')->nullable()->after('comite_depouillement');

            // Cycle d'attribution de la COJO et Période de Contestation ANRMPCI (7 jours)
            $table->date('date_attribution_provisoire')->nullable()->after('candidature_end_date');
            $table->date('fin_periode_contestation')->nullable()->after('date_attribution_provisoire'); // Délai de recours de 7 jours
            $table->date('date_attribution_definitive')->nullable()->after('fin_periode_contestation');

            // Suivi des litiges / recours auprès de l'ANRMPCI (Organe de Régulation Indépendant)
            $table->boolean('sous_recours_anrmp')->default(false)->after('date_attribution_definitive');
            $table->string('statut_recours_anrmp')->nullable()->after('sous_recours_anrmp'); // ex: 'en_instruction', 'injonction_reexamen', 'procedure_annulee', 'rejet_recours'
            $table->text('motif_recours_anrmp')->nullable()->after('statut_recours_anrmp');

            // Clôture du marché et délivrance de l'attestation
            $table->date('date_attestation_bonne_execution')->nullable()->after('motif_recours_anrmp');
        });
    }

    public function down(): void
    {
        Schema::table('markets', function (Blueprint $table) {
            $table->dropColumn([
                'comite_depouillement',
                'comite_analyse',
                'date_attribution_provisoire',
                'fin_periode_contestation',
                'date_attribution_definitive',
                'sous_recours_anrmp',
                'statut_recours_anrmp',
                'motif_recours_anrmp',
                'date_attestation_bonne_execution',
            ]);
        });
    }
};