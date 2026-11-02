<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'administrateur_systeme',
                'description' => 'Gestion globale de la plateforme et des accès utilisateurs',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'representant_bad',
                'description' => 'Représentant officiel de la Banque Africaine de Développement - Suivi stratégique',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'direction_nationale',
                'description' => 'Direction Nationale du SNGCFP - Supervision générale et rapports',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'ordonnateur',
                'description' => 'Haute autorité de validation budgétaire et d\'engagement des dépenses',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'comptable_nationale',
                'description' => 'Gestion et suivi de la comptabilité pour la contrepartie État',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'comptable_bad',
                'description' => 'Gestion et suivi des fonds et décaissements de la Banque Africaine de Développement',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'controleur_interne',
                'description' => 'Contrôle de conformité a priori, gestion des risques et alertes',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'ugp',
                'description' => 'Unité de Gestion de Projet - Création et suivi direct des projets',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'specialiste_marche',
                'description' => 'Gestion des dossiers d\'appels d\'offres et attribution des marchés publics',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'auditeur_externe',
                'description' => 'Cabinet d\'audit indépendant - Vérification annuelle des comptes et procédures',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'prestataire',
                'description' => 'Prestataire externe sur le terrain - Suivi d\'exécution des travaux',
                'platform' => 'flutter_mobile' // Changement de plateforme pour l'écosystème mobile
            ],
            [
                'name' => 'ministre',
                'description' => 'Autorité de tutelle - Consultation des tableaux de bord analytiques et bilans',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'comite_technique',
                'description' => 'Membre du comité technique - Analyse, évaluation des candidatures et désignation des tributaires de marchés',
                'platform' => 'laravel_web'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
