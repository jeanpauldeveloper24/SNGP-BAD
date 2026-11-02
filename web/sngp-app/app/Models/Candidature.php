<?php

namespace App\Models;

use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Candidature extends Model
{
    use Loggable;
    
    protected $fillable = [
        'marche_id',
        'nom_candidat',
        'numero_registre_commerce',
        'email_candidat',
        'file_rccm',
        'file_acte_constitution',
        'file_dfe',
        'file_arf',
        'file_cnps',
        'file_attestation_bancaire',
        'proposition_financiere',
        'statut_candidature', // Remplacé de 'status'
        'statut_marche',      // Nouveau champ d'attribution
        'motif_statut'
    ];

    // Cast pour manipuler le JSON de la proposition comme un tableau PHP
    protected $casts = [
        'proposition_technique' => 'array',
    ];

    /**
     * Relation avec le modèle Market (lié à la table markets)
     */
    public function market()
    {
        return $this->belongsTo(Market::class, 'marche_id');
    }

    /**
     * Workflow de tri et de rejet automatique à la création
     */
    protected static function booted()
    {
        static::creating(function ($candidature) {
            $market = $candidature->market;

            // Initialisation par défaut du statut de marché
            $candidature->statut_marche = 'en attente';

            if ($market) {
                // RÈGLE 1 : Filtrage Financier basé sur le budget converti en FCFA
                $budgetMaxFcfa = $market->besoin_financier_fcfa ?? 0;

                if ($budgetMaxFcfa > 0 && $candidature->proposition_financiere > $budgetMaxFcfa) {
                    $candidature->statut_candidature = 'refusé'; 
                    $candidature->motif_statut = "Offre financière (" . number_format($candidature->proposition_financiere, 0, ',', ' ') . " CFA) supérieure à l'enveloppe allouée du marché (" . number_format($budgetMaxFcfa, 0, ',', ' ') . " CFA).";
                    return;
                }

                // RÈGLE 2 : Filtrage Technique & Quantitatif
                $offresCandidat = $candidature->proposition_technique; 

                if (is_array($offresCandidat)) {
                    foreach ($offresCandidat as $item) {
                        if (isset($item['quantite_proposee'], $item['quantite_exigee']) && $item['quantite_proposee'] < $item['quantite_exigee']) {
                            $candidature->statut_candidature = 'refusé'; 
                            $candidature->motif_statut = "[Rejet automatique] Insuffisance technique détectée sur l'élément [ " . ($item['designation_reference'] ?? 'Article') . " ]. Quantité proposée : " . $item['quantite_proposee'] . " au lieu de " . $item['quantite_exigee'] . " minimum requis.";
                            return;
                        }
                    }
                }

                // Si tout est conforme par défaut
                $candidature->statut_candidature = 'accepté';
                $candidature->motif_statut = "Candidature conforme aux exigences financières et techniques.";
            }
        });

        // Envoi de la notification par e-mail après la création si un e-mail est présent
        static::created(function ($candidature) {
            if (!empty($candidature->email_candidat)) {
                try {
                    \Illuminate\Support\Facades\Mail::to($candidature->email_candidat)
                        ->send(new \App\Mail\NotificationStatutCandidature($candidature));
                } catch (\Exception $e) {
                    \Log::error("Erreur d'envoi d'e-mail pour la candidature #{$candidature->id} : " . $e->getMessage());
                }
            }
        });
    }
}