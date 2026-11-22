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
                'label' => 'Administrateur Système',
                'description' => 'Gestion globale de la plateforme et des accès utilisateurs',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'representant_bad',
                'label' => 'Représentant BAD',
                'description' => 'Représentant officiel de la Banque Africaine de Développement - Suivi stratégique',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'direction_nationale',
                'label' => 'Direction Nationale',
                'description' => 'Direction Nationale du SNGCFP - Supervision générale et rapports',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'ordonnateur',
                'label' => 'Ordonnateur',
                'description' => 'Haute autorité de validation budgétaire et d\'engagement des dépenses',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'comptable_nationale',
                'label' => 'Comptable National',
                'description' => 'Gestion et suivi de la comptabilité pour la contrepartie État',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'comptable_bad',
                'label' => 'Comptable BAD',
                'description' => 'Gestion et suivi des fonds et décaissements de la Banque Africaine de Développement',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'controleur_interne',
                'label' => 'Contrôleur Interne',
                'description' => 'Contrôle de conformité a priori, gestion des risques et alertes',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'ugp',
                'label' => 'Unité de Gestion de Projet (UGP)',
                'description' => 'Unité de Gestion de Projet - Création et suivi direct des projets',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'specialiste_marche',
                'label' => 'Spécialiste en Passation de Marchés',
                'description' => 'Gestion des dossiers d\'appels d\'offres et attribution des marchés publics',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'auditeur_externe',
                'label' => 'Auditeur Externe',
                'description' => 'Cabinet d\'audit indépendant - Vérification annuelle des comptes et procédures',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'prestataire',
                'label' => 'Prestataire',
                'description' => 'Prestataire externe sur le terrain - Suivi d\'exécution des travaux',
                'platform' => 'flutter_mobile'
            ],
            [
                'name' => 'ministre',
                'label' => 'Ministre / Tutelle',
                'description' => 'Autorité de tutelle - Consultation des tableaux de bord analytiques et bilans',
                'platform' => 'laravel_web'
            ],
            // Rôles COJO (Comité d'Ouverture et de Jugement des Offres) - Sous-comités
            [
                'name' => 'cojo_depouillement',
                'label' => 'Comité de Dépouillement (COJO)',
                'description' => 'Membre du comité de dépouillement (Président, Secrétaire, Membres) - Réception et dépouillement public des offres en présence des candidats',
                'platform' => 'laravel_web'
            ],
            [
                'name' => 'cojo_analyse',
                'label' => 'Comité d\'Analyse (COJO)',
                'description' => 'Membre du comité d\'analyse (Président, Secrétaire, Membres) - Analyse technique et financière des candidatures en huis clos et attribution provisoire',
                'platform' => 'laravel_web'
            ],
            // Rôle ANRMPCI (Organe de régulation)
            [
                'name' => 'anrmp',
                'label' => 'ANRMPCI',
                'description' => 'Autorité Nationale de Régulation des Marchés Publics de Côte d\'Ivoire - Instruction des recours (7 jours), injonctions de réexamen et annulation de procédures',
                'platform' => 'laravel_web'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}