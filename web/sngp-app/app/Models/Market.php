<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Market extends Model
{
    use Loggable;

    protected $fillable = [
        'numero_reference',
        'project_id',
        'project_module_id',
        'user_id',
        'created_by',
        'objet',
        'methode_passation',
        'comite_depouillement',
        'comite_analyse',
        'etape',
        'status',
        'besoin_financier',
        'besoins_materiels',
        'devise',
        'candidature_start_date',
        'candidature_end_date',
        'date_attribution_provisoire',
        'fin_periode_contestation',
        'date_attribution_definitive',
        'sous_recours_anrmp',
        'statut_recours_anrmp',
        'motif_recours_anrmp',
        'date_attestation_bonne_execution',
    ];

    /**
     * Transtypage automatique des attributs.
     */
    protected $casts = [
        'besoins_materiels'                 => 'array',
        'comite_depouillement'              => 'array',
        'comite_analyse'                    => 'array',
        'besoin_financier'                  => 'decimal:2',
        'candidature_start_date'            => 'date',
        'candidature_end_date'              => 'date',
        'date_attribution_provisoire'       => 'date',
        'fin_periode_contestation'          => 'date',
        'date_attribution_definitive'       => 'date',
        'date_attestation_bonne_execution'  => 'date',
        'sous_recours_anrmp'                => 'boolean',
    ];

    /**
     * Libellé propre de l'étape institutionnelle.
     */
    public function getEtapeActuelleLibelleAttribute(): string
    {
        $etapes = [
            'EXPRESSION_BESOIN'      => '01 - Expression du besoin',
            'REDACTION_DAO'          => '02 - Rédaction du DAO',
            'VALIDATION_DGMP'        => '03 - Validation DGMP',
            'PUBLICATION_AVIS'       => "04 - Publication de l'Avis",
            'RECEPTION_OFFRES'       => '05 - Réception & Dépouillement public (Comité de Dépouillement COJO)',
            'EVALUATION_TECHNIQUE'   => '06 - Analyse des offres en huis clos (Comité d\'Analyse COJO)',
            'ATTRIBUTION_PROVISOIRE' => '07 - Attribution Provisoire (COJO)',
            'PERIODE_CONTESTATION'   => '08 - Période de Contestation ANRMPCI (7 jours)',
            'ATTRIBUTION_DEFINITIVE' => '09 - Attribution Définitive (COJO)',
            'SIGNATURE_CONTRAT'      => '10 - Signature du Contrat',
            'ORDRE_SERVICE'          => '11 - Ordre de Service (OS)',
            'EXECUTION_TRAVAUX'      => '12 - Exécution des travaux',
            'ATTESTATION_EXECUTION'  => '13 - Délivrance de l\'Attestation de Bonne Exécution',
            'RECEPTION_DEFINITIVE'   => '14 - Réception définitive',
        ];

        return $etapes[$this->etape] ?? ($this->etape ?? 'Non définie');
    }

    // --- RELATIONS ---

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(ProjectModule::class, 'project_module_id');
    }

    public function titulaire(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected $guarded = [];

    /**
     * Convertit le besoin financier dans la devise d'origine en FCFA (XOF) via ExchangeRate-API.
     */
    public function getBesoinFinancierFcfaAttribute()
    {
        $montant = $this->besoin_financier ?? 0;
        $devise = strtoupper($this->devise ?? 'USD');

        if (in_array($devise, ['XOF', 'FCFA'])) {
            return $montant;
        }

        $tauxUsdXof = 600;
        $tauxUsdEur = 0.92;

        try {
            $rates = Cache::remember('exchange_rates_cfa', 86400, function () {
                try {
                    $apiKey = env('EXCHANGERATE_API_KEY');
                    $response = Http::withoutVerifying()
                        ->timeout(2)
                        ->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");

                    if ($response->successful()) {
                        $data = $response->json();
                        return $data['conversion_rates'] ?? [];
                    }
                } catch (\Exception $e) {
                    // Repli par défaut
                }
                return [];
            });

            if (!empty($rates)) {
                $tauxUsdXof = $rates['XOF'] ?? 600;
                $tauxUsdEur = $rates['EUR'] ?? 0.92;
            }
        } catch (\Exception $e) {
            // Sécurité globale
        }

        if ($devise === 'USD') {
            return $montant * $tauxUsdXof;
        }

        if ($devise === 'EUR') {
            $montantUsd = $montant / $tauxUsdEur;
            return $montantUsd * $tauxUsdXof;
        }

        return $montant;
    }
}