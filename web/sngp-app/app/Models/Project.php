<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property float $budget_initial
 * @property string $budget_devise
 * @property float $budget_value
 * @property float $taux_change
 * @property-read float $budget_in_fcfa
 */
class Project extends Model
{
    use Loggable;

    // Constantes pour les statuts du projet
    const STATUS_BROUILLON = 'brouillon';
    const STATUS_EN_COURS = 'en_cours';
    const STATUS_TERMINE = 'termine';
    const STATUS_SUSPENDU = 'suspendu';

    protected $fillable = [
        'code',
        'nom',
        'description',
        'secteur_activite',
        'categorie',
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
        'pnd_pilier_id',
        'circonscription_id',
    ];

    protected $casts = [
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

    /**
     * Accesseur : Calcule le budget en FCFA selon la devise et le taux du projet
     */
    public function getBudgetInFcfaAttribute(): float
    {
        $devise = strtoupper($this->budget_devise ?? 'XOF');
        $initial = (float) ($this->budget_initial ?? 0);
        $value = (float) ($this->budget_value ?? 0);
        $taux = (float) ($this->taux_change ?? 1);

        // Si la devise est déjà le FCFA / XOF
        if (in_array($devise, ['FCFA', 'XOF'])) {
            return $initial;
        }

        // Si budget_value contient déjà le montant converti en FCFA
        if ($value > 0) {
            return $value;
        }

        // Conversion avec le taux de change
        return $initial * $taux;
    }

    /**
     * Scope pour filtrer les projets terminés
     */
    public function scopeTermines($query)
    {
        return $query->where('status', self::STATUS_TERMINE);
    }

    /**
     * Scope pour filtrer les projets en cours
     */
    public function scopeEnCours($query)
    {
        return $query->where('status', self::STATUS_EN_COURS);
    }

    /**
     * Relation : Un projet est rattaché à un unique pilier du PND.
     */
    public function pndPilier(): BelongsTo
    {
        return $this->belongsTo(PndPilier::class, 'pnd_pilier_id');
    }

    /**
     * Relation : Un projet est rattaché à une unique circonscription administrative.
     */
    public function circonscription(): BelongsTo
    {
        return $this->belongsTo(Circonscription::class, 'circonscription_id');
    }

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