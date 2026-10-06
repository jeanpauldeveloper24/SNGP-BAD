<?php

namespace App\Services;

use App\Models\Project;
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
        'travaux'                  => 'TRV',
        'fournitures'              => 'FRN',
        'services_courants'        => 'SVC',
        'prestations_intellectuelles' => 'INT',
    ];

    /**
     * Génère un code projet selon la structure :
     * REG(n)-COM(n)-SEC(n)-CAT(n)-SEQ(00n)
     * Ex: ABJ1-YOP2-ENE3-TRV1-005
     */
    public static function generate(array $data): string
    {
        $regionName   = trim($data['region'] ?? 'REGION');
        $communeName  = trim($data['commune'] ?? $data['ville'] ?? 'COMMUNE');
        $secteurKey   = $data['secteur_activite'] ?? 'btp';
        $categorieKey = $data['categorie'] ?? 'travaux';

        // Troncature des préfixes (3 lettres majuscules)
        $regionCode  = Str::upper(Str::substr($regionName, 0, 3));
        $communeCode = Str::upper(Str::substr($communeName, 0, 3));
        $secteurCode = self::$secteurs[$secteurKey] ?? 'SEC';
        $catCode     = self::$categories[$categorieKey] ?? 'CAT';

        // Compteurs contextuels dynamiques en BDD
        $numRegion   = Project::where('region', $regionName)->count() + 1;
        $numCommune  = Project::where(function($q) use ($communeName) {
            $q->where('commune', $communeName)->orWhere('ville', $communeName);
        })->count() + 1;
        $numSecteur  = Project::where('secteur_activite', $secteurKey)->count() + 1;
        $numCategorie= Project::where('categorie', $categorieKey)->count() + 1;
        $numSequence = Project::whereYear('created_at', now()->year)->count() + 1;

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