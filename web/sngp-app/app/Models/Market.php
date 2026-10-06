<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'etape',
        'status',
        'besoin_financier',
        'besoins_materiels',
        'devise',
        'candidature_start_date',
        'candidature_end_date',
    ];

    /**
     * Transtypage automatique des attributs.
     */
    protected $casts = [
        'besoins_materiels'      => 'array',
        'besoin_financier'       => 'decimal:2',
        'candidature_start_date' => 'date',
        'candidature_end_date'   => 'date',
    ];

    /**
     * Libellé propre de l'étape.
     */
    public function getEtapeActuelleLibelleAttribute(): string
    {
        $etapes = [
            'EXPRESSION_BESOIN'      => '01 - Expression du besoin',
            'REDACTION_DAO'          => '02 - Rédaction du DAO',
            'VALIDATION_DGMP'        => '03 - Validation DGMP',
            'PUBLICATION_AVIS'       => "04 - Publication de l'Avis",
            'RECEPTION_OFFRES'       => '05 - Réception des offres',
            'OUVERTURE_PLIS'         => '06 - Ouverture des plis',
            'EVALUATION_TECHNIQUE'   => '07 - Évaluation Technique',
            'ATTRIBUTION_PROVISOIRE' => '08 - Attribution Provisoire',
            'SIGNATURE_CONTRAT'     => '09 - Signature du Contrat',
            'ORDRE_SERVICE'          => '10 - Ordre de Service (OS)',
            'PREMIER_VERSEMENT'      => '11 - 1er versement',
            'EXECUTION_TRAVAUX'      => '12 - Exécution des travaux',
            'SECOND_VERSEMENT'       => '13 - 2nd versement',
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
}