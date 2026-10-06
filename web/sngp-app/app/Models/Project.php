<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use Loggable;

    protected $fillable = [
        'code',
        'nom',
        'description',
        'secteur_activite',
        'categorie',
        'region',
        'departement',
        'commune',
        'ville',
        'zones_couvertes',
        'budget_initial',
        'budget_devise',
        'budget_value',
        'taux_change',
        'financement_bailleur',
        'financement_etat',
        'pourcentage_bailleur',
        'pourcentage_etat',
        'start_date',
        'end_date',
        'taux_execution',
        'status',
        'user_id',
        'validated_by',
    ];

    protected $casts = [
        'zones_couvertes'      => 'array',
        'budget_initial'       => 'decimal:2',
        'budget_value'         => 'decimal:2',
        'taux_change'          => 'decimal:4',
        'financement_bailleur' => 'decimal:2',
        'financement_etat'     => 'decimal:2',
        'pourcentage_bailleur' => 'decimal:2',
        'pourcentage_etat'     => 'decimal:2',
        'start_date'           => 'date',
        'end_date'             => 'date',
    ];

    public function modules(): HasMany
    {
        return $this->hasMany(ProjectModule::class);
    }

    public function paiements(): HasMany
    {
        return $this->hasMany(Paiement::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}