<?php

namespace Database\Seeders;

use App\Models\PndVersion;
use App\Models\PndPilier;
use Illuminate\Database\Seeder;

class PndSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nettoyage préalable des tables
        PndPilier::query()->delete();
        PndVersion::query()->delete();

        // 1. Création de la version du PND 2026-2030
        $pnd = PndVersion::create([
            'version' => 'PND 2026-2030',
            'start_date' => '2026-01-01',
            'end_date' => '2030-12-31',
            'nombre_pilier' => 6,
            'is_active' => true,
        ]);

        // 2. Définition des 6 piliers officiels
        $piliers = [
            [
                'numero' => 1,
                'libelle' => 'Paix, sécurité et stabilité durables',
            ],
            [
                'numero' => 2,
                'libelle' => 'Moderniser l\'agriculture, sécuriser la tenure foncière rurale, augmenter la productivité et renforcer les chaînes de valeur agricoles',
            ],
            [
                'numero' => 3,
                'libelle' => 'Promouvoir l\'investissement privé et les champions nationaux, et réduire l\'informalité',
            ],
            [
                'numero' => 4,
                'libelle' => 'Développer le capital humain et les compétences, et créer des emplois décents',
            ],
            [
                'numero' => 5,
                'libelle' => 'Développer des infrastructures stratégiques et des pôles économiques régionaux ; transition écologique, résilience climatique et économie circulaire',
            ],
            [
                'numero' => 6,
                'libelle' => 'Promouvoir la bonne gouvernance et moderniser l\'État',
            ],
        ];

        // 3. Insertion des piliers associés
        foreach ($piliers as $pilier) {
            PndPilier::create([
                'pnd_version_id' => $pnd->id,
                'numero' => $pilier['numero'],
                'libelle' => $pilier['libelle'],
            ]);
        }
    }
}