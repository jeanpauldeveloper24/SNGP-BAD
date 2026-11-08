<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Circonscription;
use Illuminate\Support\Str;

class ProjectCodeGenerator
{
    public static array $secteurs = [
        'btp'         => 'BTP',
        'sante'       => 'SAN',
        'education'   => 'EDU',
        'energie'     => 'ENE',
        'tic'         => 'TIC',
        'agriculture' => 'AGR',
        'transport'   => 'TRA',
    ];

    public static array $categories = [
        'travaux'                   => 'TRV',
        'fournitures'               => 'FRN',
        'services_courants'         => 'SVC',
        'prestations_intellectuelles' => 'INT',
    ];

    /**
     * Génère un code projet selon la structure :
     * REG(n)-COM(n)-SEC(n)-CAT(n)-SEQ(00n)
     * Ex: POR1-KOR1-ENE1-TRV1-001
     */
    public static function generate(array $data): string
    {
        // Récupération de la circonscription liée si l'ID est fourni dans les données
        $circonscriptionName = 'REGION';
        $villeName = 'COMMUNE';

        if (!empty($data['circonscription_id'])) {
            $circonscription = Circonscription::find($data['circonscription_id']);
            if ($circonscription) {
                $circonscriptionName = $circonscription->nom;
                $villeName = $circonscription->nom;
            }
        }

        $secteurKey   = $data['secteur_activite'] ?? 'btp';
        $categorieKey = $data['categorie'] ?? 'travaux';

        // Troncature des préfixes (3 lettres majuscules)
        $regionCode  = Str::upper(Str::substr($circonscriptionName, 0, 3));
        $communeCode = Str::upper(Str::substr($villeName, 0, 3));
        $secteurCode = self::$secteurs[$secteurKey] ?? 'SEC';
        $catCode     = self::$categories[$categorieKey] ?? 'CAT';

        // Compteurs basés sur les colonnes existantes en BDD (sans chercher 'region' ou 'commune')
        $numSecteur   = Project::where('secteur_activite', $secteurKey)->count() + 1;
        $numCategorie = Project::where('categorie', $categorieKey)->count() + 1;
        $numSequence  = Project::whereYear('created_at', now()->year)->count() + 1;

        // Pour les compteurs géographiques basés sur la circonscription
        $numRegion = 1;
        $numCommune = 1;
        if (!empty($data['circonscription_id'])) {
            $numRegion = Project::where('circonscription_id', $data['circonscription_id'])->count() + 1;
            $numCommune = $numRegion;
        }

        return sprintf(
            '%s%d-%s%d-%s%d-%s%d-%s',
            $regionCode,  $numRegion,
            $communeCode, $numCommune,
            $secteurCode, $numSecteur,
            $catCode,     $numCategorie,
            sprintf('%03d', $numSequence)
        );
    }
}