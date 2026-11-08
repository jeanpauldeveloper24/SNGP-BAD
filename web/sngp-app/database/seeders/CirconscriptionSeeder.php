<?php

namespace Database\Seeders;

use App\Models\Circonscription;
use Illuminate\Database\Seeder;

class CirconscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Vider la table avant de semer pour éviter les doublons
        Circonscription::query()->delete();

        // Définition de l'arborescence administrative complète de la Côte d'Ivoire (2026)
        $donnees = [
            // ==========================================
            // DISTRICTS AUTONOMES
            // ==========================================
            [
                'nom' => "District Autonome d'Abidjan",
                'type' => 'district_autonome',
                'chef_lieu' => 'Abidjan',
                'code_officiel' => 'DA-ABJ',
                'enfants' => [
                    [
                        'nom' => 'Abidjan',
                        'type' => 'departement',
                        'chef_lieu' => 'Abidjan',
                        'code_officiel' => 'DP-ABJ',
                        'enfants' => [
                            [
                                'nom' => 'Abidjan (Sous-Préfecture)',
                                'type' => 'sous_prefecture',
                                'chef_lieu' => 'Abidjan',
                                'code_officiel' => 'SP-ABJ',
                                'enfants' => [
                                    ['nom' => 'Plateau', 'type' => 'commune', 'chef_lieu' => 'Plateau', 'code_officiel' => 'CM-PLT'],
                                    ['nom' => 'Cocody', 'type' => 'commune', 'chef_lieu' => 'Cocody', 'code_officiel' => 'CM-CCD'],
                                    ['nom' => 'Yopougon', 'type' => 'commune', 'chef_lieu' => 'Yopougon', 'code_officiel' => 'CM-YPG'],
                                    ['nom' => 'Abobo', 'type' => 'commune', 'chef_lieu' => 'Abobo', 'code_officiel' => 'CM-ABB'],
                                    ['nom' => 'Adjamé', 'type' => 'commune', 'chef_lieu' => 'Adjamé', 'code_officiel' => 'CM-ADM'],
                                    ['nom' => 'Treichville', 'type' => 'commune', 'chef_lieu' => 'Treichville', 'code_officiel' => 'CM-TRC'],
                                    ['nom' => 'Marcory', 'type' => 'commune', 'chef_lieu' => 'Marcory', 'code_officiel' => 'CM-MRC'],
                                    ['nom' => 'Koumassi', 'type' => 'commune', 'chef_lieu' => 'Koumassi', 'code_officiel' => 'CM-KMS'],
                                    ['nom' => 'Port-Bouët', 'type' => 'commune', 'chef_lieu' => 'Port-Bouët', 'code_officiel' => 'CM-PTB'],
                                    ['nom' => 'Attécoubé', 'type' => 'commune', 'chef_lieu' => 'Attécoubé', 'code_officiel' => 'CM-ATC'],
                                ],
                            ],
                            [
                                'nom' => 'Bingerville',
                                'type' => 'sous_prefecture',
                                'chef_lieu' => 'Bingerville',
                                'code_officiel' => 'SP-BNG',
                                'enfants' => [
                                    ['nom' => 'Bingerville', 'type' => 'commune', 'chef_lieu' => 'Bingerville', 'code_officiel' => 'CM-BNG'],
                                ],
                            ],
                            [
                                'nom' => 'Anyama',
                                'type' => 'sous_prefecture',
                                'chef_lieu' => 'Anyama',
                                'code_officiel' => 'SP-ANY',
                                'enfants' => [
                                    ['nom' => 'Anyama', 'type' => 'commune', 'chef_lieu' => 'Anyama', 'code_officiel' => 'CM-ANY'],
                                    ['nom' => 'Songon', 'type' => 'commune', 'chef_lieu' => 'Songon', 'code_officiel' => 'CM-SGN'],
                                ],
                            ],
                            [
                                'nom' => 'Brofodoumé',
                                'type' => 'sous_prefecture',
                                'chef_lieu' => 'Brofodoumé',
                                'code_officiel' => 'SP-BRF',
                                'enfants' => [],
                            ],
                        ],
                    ],
                ],
            ],
            [
                'nom' => "District Autonome de Yamoussoukro",
                'type' => 'district_autonome',
                'chef_lieu' => 'Yamoussoukro',
                'code_officiel' => 'DA-YMK',
                'enfants' => [
                    [
                        'nom' => 'Yamoussoukro',
                        'type' => 'departement',
                        'chef_lieu' => 'Yamoussoukro',
                        'code_officiel' => 'DP-YMK',
                        'enfants' => [
                            [
                                'nom' => 'Yamoussoukro (Sous-Préfecture)',
                                'type' => 'sous_prefecture',
                                'chef_lieu' => 'Yamoussoukro',
                                'code_officiel' => 'SP-YMK',
                                'enfants' => [
                                    ['nom' => 'Yamoussoukro', 'type' => 'commune', 'chef_lieu' => 'Yamoussoukro', 'code_officiel' => 'CM-YMK'],
                                ],
                            ],
                            [
                                'nom' => 'Kossou',
                                'type' => 'sous_prefecture',
                                'chef_lieu' => 'Kossou',
                                'code_officiel' => 'SP-KSS',
                                'enfants' => [
                                    ['nom' => 'Attégouakro', 'type' => 'commune', 'chef_lieu' => 'Attégouakro', 'code_officiel' => 'CM-ATG'],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            // ==========================================
            // RÉGIONS
            // ==========================================
            [
                'nom' => 'Agnéby-Tiassa',
                'type' => 'region',
                'chef_lieu' => 'Agboville',
                'code_officiel' => 'RG-AGT',
                'enfants' => [
                    [
                        'nom' => 'Agboville',
                        'type' => 'departement',
                        'chef_lieu' => 'Agboville',
                        'code_officiel' => 'DP-AGB',
                        'enfants' => [
                            ['nom' => 'Agboville (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Agboville', 'code_officiel' => 'SP-AGB'],
                            ['nom' => 'Rubino', 'type' => 'sous_prefecture', 'chef_lieu' => 'Rubino', 'code_officiel' => 'SP-RBN'],
                            ['nom' => 'Céchi', 'type' => 'sous_prefecture', 'chef_lieu' => 'Céchi', 'code_officiel' => 'SP-CCH'],
                            ['nom' => 'Agboville', 'type' => 'commune', 'chef_lieu' => 'Agboville', 'code_officiel' => 'CM-AGB'],
                            ['nom' => 'Rubino', 'type' => 'commune', 'chef_lieu' => 'Rubino', 'code_officiel' => 'CM-RBN'],
                        ],
                    ],
                    [
                        'nom' => 'Sikensi',
                        'type' => 'departement',
                        'chef_lieu' => 'Sikensi',
                        'code_officiel' => 'DP-SKS',
                        'enfants' => [
                            ['nom' => 'Sikensi (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sikensi', 'code_officiel' => 'SP-SKS'],
                            ['nom' => 'Sikensi', 'type' => 'commune', 'chef_lieu' => 'Sikensi', 'code_officiel' => 'CM-SKS'],
                        ],
                    ],
                    [
                        'nom' => 'Tiassalé',
                        'type' => 'departement',
                        'chef_lieu' => 'Tiassalé',
                        'code_officiel' => 'DP-TSL',
                        'enfants' => [
                            ['nom' => 'Tiassalé (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tiassalé', 'code_officiel' => 'SP-TSL'],
                            ['nom' => 'N\'douci', 'type' => 'sous_prefecture', 'chef_lieu' => 'N\'douci', 'code_officiel' => 'SP-NDC'],
                            ['nom' => 'Tiassalé', 'type' => 'commune', 'chef_lieu' => 'Tiassalé', 'code_officiel' => 'CM-TSL'],
                        ],
                    ],
                    [
                        'nom' => 'Taabo',
                        'type' => 'departement',
                        'chef_lieu' => 'Taabo',
                        'code_officiel' => 'DP-TAB',
                        'enfants' => [
                            ['nom' => 'Taabo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Taabo', 'code_officiel' => 'SP-TAB'],
                            ['nom' => 'Taabo', 'type' => 'commune', 'chef_lieu' => 'Taabo', 'code_officiel' => 'CM-TAB'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Bafing',
                'type' => 'region',
                'chef_lieu' => 'Touba',
                'code_officiel' => 'RG-BAF',
                'enfants' => [
                    [
                        'nom' => 'Touba',
                        'type' => 'departement',
                        'chef_lieu' => 'Touba',
                        'code_officiel' => 'DP-TOU',
                        'enfants' => [
                            ['nom' => 'Touba (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Touba', 'code_officiel' => 'SP-TOU'],
                            ['nom' => 'Borotou', 'type' => 'sous_prefecture', 'chef_lieu' => 'Borotou', 'code_officiel' => 'SP-BRT'],
                            ['nom' => 'Touba', 'type' => 'commune', 'chef_lieu' => 'Touba', 'code_officiel' => 'CM-TOU'],
                            ['nom' => 'Borotou', 'type' => 'commune', 'chef_lieu' => 'Borotou', 'code_officiel' => 'CM-BRT'],
                            ['nom' => 'Booko', 'type' => 'commune', 'chef_lieu' => 'Booko', 'code_officiel' => 'CM-BKO'],
                        ],
                    ],
                    [
                        'nom' => 'Koro',
                        'type' => 'departement',
                        'chef_lieu' => 'Koro',
                        'code_officiel' => 'DP-KRO',
                        'enfants' => [
                            ['nom' => 'Koro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Koro', 'code_officiel' => 'SP-KRO'],
                            ['nom' => 'Koro', 'type' => 'commune', 'chef_lieu' => 'Koro', 'code_officiel' => 'CM-KRO'],
                        ],
                    ],
                    [
                        'nom' => 'Ouaninou',
                        'type' => 'departement',
                        'chef_lieu' => 'Ouaninou',
                        'code_officiel' => 'DP-OAN',
                        'enfants' => [
                            ['nom' => 'Ouaninou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Ouaninou', 'code_officiel' => 'SP-OAN'],
                            ['nom' => 'Koonan', 'type' => 'sous_prefecture', 'chef_lieu' => 'Koonan', 'code_officiel' => 'SP-KNN'],
                            ['nom' => 'Ouaninou', 'type' => 'commune', 'chef_lieu' => 'Ouaninou', 'code_officiel' => 'CM-OAN'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Bagoué',
                'type' => 'region',
                'chef_lieu' => 'Boundiali',
                'code_officiel' => 'RG-BAG',
                'enfants' => [
                    [
                        'nom' => 'Boundiali',
                        'type' => 'departement',
                        'chef_lieu' => 'Boundiali',
                        'code_officiel' => 'DP-BND',
                        'enfants' => [
                            ['nom' => 'Boundiali (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Boundiali', 'code_officiel' => 'SP-BND'],
                            ['nom' => 'Kanakono', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kanakono', 'code_officiel' => 'SP-KNK'],
                            ['nom' => 'Blességué', 'type' => 'sous_prefecture', 'chef_lieu' => 'Blességué', 'code_officiel' => 'SP-BLS'],
                            ['nom' => 'Boundiali', 'type' => 'commune', 'chef_lieu' => 'Boundiali', 'code_officiel' => 'CM-BND'],
                        ],
                    ],
                    [
                        'nom' => 'Kouto',
                        'type' => 'departement',
                        'chef_lieu' => 'Kouto',
                        'code_officiel' => 'DP-KTO',
                        'enfants' => [
                            ['nom' => 'Kouto (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kouto', 'code_officiel' => 'SP-KTO'],
                            ['nom' => 'Gbon', 'type' => 'sous_prefecture', 'chef_lieu' => 'Gbon', 'code_officiel' => 'SP-GBN'],
                            ['nom' => 'Kouto', 'type' => 'commune', 'chef_lieu' => 'Kouto', 'code_officiel' => 'CM-KTO'],
                            ['nom' => 'Gbon', 'type' => 'commune', 'chef_lieu' => 'Gbon', 'code_officiel' => 'CM-GBN'],
                            ['nom' => 'Kolia', 'type' => 'commune', 'chef_lieu' => 'Kolia', 'code_officiel' => 'CM-KLA'],
                        ],
                    ],
                    [
                        'nom' => 'Tengréla',
                        'type' => 'departement',
                        'chef_lieu' => 'Tengréla',
                        'code_officiel' => 'DP-TGR',
                        'enfants' => [
                            ['nom' => 'Tengréla (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tengréla', 'code_officiel' => 'SP-TGR'],
                            ['nom' => 'Tengréla', 'type' => 'commune', 'chef_lieu' => 'Tengréla', 'code_officiel' => 'CM-TGR'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Bélier',
                'type' => 'region',
                'chef_lieu' => 'Toumodi',
                'code_officiel' => 'RG-BLR',
                'enfants' => [
                    [
                        'nom' => 'Toumodi',
                        'type' => 'departement',
                        'chef_lieu' => 'Toumodi',
                        'code_officiel' => 'DP-TMD',
                        'enfants' => [
                            ['nom' => 'Toumodi (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Toumodi', 'code_officiel' => 'SP-TMD'],
                            ['nom' => 'Kokumbo', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kokumbo', 'code_officiel' => 'SP-KKM'],
                            ['nom' => 'Toumodi', 'type' => 'commune', 'chef_lieu' => 'Toumodi', 'code_officiel' => 'CM-TMD'],
                            ['nom' => 'Kokumbo', 'type' => 'commune', 'chef_lieu' => 'Kokumbo', 'code_officiel' => 'CM-KKM'],
                        ],
                    ],
                    [
                        'nom' => 'Didiévi',
                        'type' => 'departement',
                        'chef_lieu' => 'Didiévi',
                        'code_officiel' => 'DP-DDV',
                        'enfants' => [
                            ['nom' => 'Didiévi (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Didiévi', 'code_officiel' => 'SP-DDV'],
                            ['nom' => 'Didiévi', 'type' => 'commune', 'chef_lieu' => 'Didiévi', 'code_officiel' => 'CM-DDV'],
                        ],
                    ],
                    [
                        'nom' => 'Djékanou',
                        'type' => 'departement',
                        'chef_lieu' => 'Djékanou',
                        'code_officiel' => 'DP-DJK',
                        'enfants' => [
                            ['nom' => 'Djékanou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Djékanou', 'code_officiel' => 'SP-DJK'],
                            ['nom' => 'Djékanou', 'type' => 'commune', 'chef_lieu' => 'Djékanou', 'code_officiel' => 'CM-DJK'],
                        ],
                    ],
                    [
                        'nom' => 'Tiébissou',
                        'type' => 'departement',
                        'chef_lieu' => 'Tiébissou',
                        'code_officiel' => 'DP-TBS',
                        'enfants' => [
                            ['nom' => 'Tiébissou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tiébissou', 'code_officiel' => 'SP-TBS'],
                            ['nom' => 'Tiébissou', 'type' => 'commune', 'chef_lieu' => 'Tiébissou', 'code_officiel' => 'CM-TBS'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Béré',
                'type' => 'region',
                'chef_lieu' => 'Mankono',
                'code_officiel' => 'RG-BRE',
                'enfants' => [
                    [
                        'nom' => 'Mankono',
                        'type' => 'departement',
                        'chef_lieu' => 'Mankono',
                        'code_officiel' => 'DP-MKN',
                        'enfants' => [
                            ['nom' => 'Mankono (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Mankono', 'code_officiel' => 'SP-MKN'],
                            ['nom' => 'Kongasso', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kongasso', 'code_officiel' => 'SP-KGS'],
                            ['nom' => 'Sarhala', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sarhala', 'code_officiel' => 'SP-SRH'],
                            ['nom' => 'Mankono', 'type' => 'commune', 'chef_lieu' => 'Mankono', 'code_officiel' => 'CM-MKN'],
                        ],
                    ],
                    [
                        'nom' => 'Kounahiri',
                        'type' => 'departement',
                        'chef_lieu' => 'Kounahiri',
                        'code_officiel' => 'DP-KNH',
                        'enfants' => [
                            ['nom' => 'Kounahiri (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kounahiri', 'code_officiel' => 'SP-KNH'],
                            ['nom' => 'Kounahiri', 'type' => 'commune', 'chef_lieu' => 'Kounahiri', 'code_officiel' => 'CM-KNH'],
                        ],
                    ],
                    [
                        'nom' => 'Dianra',
                        'type' => 'departement',
                        'chef_lieu' => 'Dianra',
                        'code_officiel' => 'DP-DNR',
                        'enfants' => [
                            ['nom' => 'Dianra (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Dianra', 'code_officiel' => 'SP-DNR'],
                            ['nom' => 'Dianra', 'type' => 'commune', 'chef_lieu' => 'Dianra', 'code_officiel' => 'CM-DNR'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Bounkani',
                'type' => 'region',
                'chef_lieu' => 'Bouna',
                'code_officiel' => 'RG-BNK',
                'enfants' => [
                    [
                        'nom' => 'Bouna',
                        'type' => 'departement',
                        'chef_lieu' => 'Bouna',
                        'code_officiel' => 'DP-BNA',
                        'enfants' => [
                            ['nom' => 'Bouna (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bouna', 'code_officiel' => 'SP-BNA'],
                            ['nom' => 'Togolokaye', 'type' => 'sous_prefecture', 'chef_lieu' => 'Togolokaye', 'code_officiel' => 'SP-TGL'],
                            ['nom' => 'Bouna', 'type' => 'commune', 'chef_lieu' => 'Bouna', 'code_officiel' => 'CM-BNA'],
                        ],
                    ],
                    [
                        'nom' => 'Doropo',
                        'type' => 'departement',
                        'chef_lieu' => 'Doropo',
                        'code_officiel' => 'DP-DRP',
                        'enfants' => [
                            ['nom' => 'Doropo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Doropo', 'code_officiel' => 'SP-DRP'],
                            ['nom' => 'Doropo', 'type' => 'commune', 'chef_lieu' => 'Doropo', 'code_officiel' => 'CM-DRP'],
                        ],
                    ],
                    [
                        'nom' => 'Nassian',
                        'type' => 'departement',
                        'chef_lieu' => 'Nassian',
                        'code_officiel' => 'DP-NSS',
                        'enfants' => [
                            ['nom' => 'Nassian (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Nassian', 'code_officiel' => 'SP-NSS'],
                            ['nom' => 'Nassian', 'type' => 'commune', 'chef_lieu' => 'Nassian', 'code_officiel' => 'CM-NSS'],
                        ],
                    ],
                    [
                        'nom' => 'Téhini',
                        'type' => 'departement',
                        'chef_lieu' => 'Téhini',
                        'code_officiel' => 'DP-THN',
                        'enfants' => [
                            ['nom' => 'Téhini (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Téhini', 'code_officiel' => 'SP-THN'],
                            ['nom' => 'Téhini', 'type' => 'commune', 'chef_lieu' => 'Téhini', 'code_officiel' => 'CM-THN'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Cavally',
                'type' => 'region',
                'chef_lieu' => 'Guiglo',
                'code_officiel' => 'RG-CVL',
                'enfants' => [
                    [
                        'nom' => 'Guiglo',
                        'type' => 'departement',
                        'chef_lieu' => 'Guiglo',
                        'code_officiel' => 'DP-GGL',
                        'enfants' => [
                            ['nom' => 'Guiglo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Guiglo', 'code_officiel' => 'SP-GGL'],
                            ['nom' => 'Kaade', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kaade', 'code_officiel' => 'SP-KDE'],
                            ['nom' => 'Guiglo', 'type' => 'commune', 'chef_lieu' => 'Guiglo', 'code_officiel' => 'CM-GGL'],
                        ],
                    ],
                    [
                        'nom' => 'Bloléquin',
                        'type' => 'departement',
                        'chef_lieu' => 'Bloléquin',
                        'code_officiel' => 'DP-BLQ',
                        'enfants' => [
                            ['nom' => 'Bloléquin (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bloléquin', 'code_officiel' => 'SP-BLQ'],
                            ['nom' => 'Tinhou', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tinhou', 'code_officiel' => 'SP-TNH'],
                            ['nom' => 'Bloléquin', 'type' => 'commune', 'chef_lieu' => 'Bloléquin', 'code_officiel' => 'CM-BLQ'],
                        ],
                    ],
                    [
                        'nom' => 'Toulepleu',
                        'type' => 'departement',
                        'chef_lieu' => 'Toulepleu',
                        'code_officiel' => 'DP-TLP',
                        'enfants' => [
                            ['nom' => 'Toulepleu (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Toulepleu', 'code_officiel' => 'SP-TLP'],
                            ['nom' => 'Toulepleu', 'type' => 'commune', 'chef_lieu' => 'Toulepleu', 'code_officiel' => 'CM-TLP'],
                        ],
                    ],
                    [
                        'nom' => 'Taï',
                        'type' => 'departement',
                        'chef_lieu' => 'Taï',
                        'code_officiel' => 'DP-TAI',
                        'enfants' => [
                            ['nom' => 'Taï (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Taï', 'code_officiel' => 'SP-TAI'],
                            ['nom' => 'Taï', 'type' => 'commune', 'chef_lieu' => 'Taï', 'code_officiel' => 'CM-TAI'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Folon',
                'type' => 'region',
                'chef_lieu' => 'Minignan',
                'code_officiel' => 'RG-FLN',
                'enfants' => [
                    [
                        'nom' => 'Minignan',
                        'type' => 'departement',
                        'chef_lieu' => 'Minignan',
                        'code_officiel' => 'DP-MNN',
                        'enfants' => [
                            ['nom' => 'Minignan (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Minignan', 'code_officiel' => 'SP-MNN'],
                            ['nom' => 'Goulia', 'type' => 'sous_prefecture', 'chef_lieu' => 'Goulia', 'code_officiel' => 'SP-GLA'],
                            ['nom' => 'Minignan', 'type' => 'commune', 'chef_lieu' => 'Minignan', 'code_officiel' => 'CM-MNN'],
                        ],
                    ],
                    [
                        'nom' => 'Kaniasso',
                        'type' => 'departement',
                        'chef_lieu' => 'Kaniasso',
                        'code_officiel' => 'DP-KNS',
                        'enfants' => [
                            ['nom' => 'Kaniasso (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kaniasso', 'code_officiel' => 'SP-KNS'],
                            ['nom' => 'Sokoro', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sokoro', 'code_officiel' => 'SP-SKR'],
                            ['nom' => 'Kaniasso', 'type' => 'commune', 'chef_lieu' => 'Kaniasso', 'code_officiel' => 'CM-KNS'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Gbêkê',
                'type' => 'region',
                'chef_lieu' => 'Bouaké',
                'code_officiel' => 'RG-GBK',
                'enfants' => [
                    [
                        'nom' => 'Bouaké',
                        'type' => 'departement',
                        'chef_lieu' => 'Bouaké',
                        'code_officiel' => 'DP-BKÉ',
                        'enfants' => [
                            ['nom' => 'Bouaké (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bouaké', 'code_officiel' => 'SP-BKÉ'],
                            ['nom' => 'Brobo', 'type' => 'sous_prefecture', 'chef_lieu' => 'Brobo', 'code_officiel' => 'SP-BRB'],
                            ['nom' => 'Bouaké', 'type' => 'commune', 'chef_lieu' => 'Bouaké', 'code_officiel' => 'CM-BKÉ'],
                            ['nom' => 'Brobo', 'type' => 'commune', 'chef_lieu' => 'Brobo', 'code_officiel' => 'CM-BRB'],
                        ],
                    ],
                    [
                        'nom' => 'Béoumi',
                        'type' => 'departement',
                        'chef_lieu' => 'Béoumi',
                        'code_officiel' => 'DP-BOM',
                        'enfants' => [
                            ['nom' => 'Béoumi (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Béoumi', 'code_officiel' => 'SP-BOM'],
                            ['nom' => 'Bodokro', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bodokro', 'code_officiel' => 'SP-BDK'],
                            ['nom' => 'Béoumi', 'type' => 'commune', 'chef_lieu' => 'Béoumi', 'code_officiel' => 'CM-BOM'],
                        ],
                    ],
                    [
                        'nom' => 'Botro',
                        'type' => 'departement',
                        'chef_lieu' => 'Botro',
                        'code_officiel' => 'DP-BTR',
                        'enfants' => [
                            ['nom' => 'Botro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Botro', 'code_officiel' => 'SP-BTR'],
                            ['nom' => 'Botro', 'type' => 'commune', 'chef_lieu' => 'Botro', 'code_officiel' => 'CM-BTR'],
                        ],
                    ],
                    [
                        'nom' => 'Sakassou',
                        'type' => 'departement',
                        'chef_lieu' => 'Sakassou',
                        'code_officiel' => 'DP-SKS2',
                        'enfants' => [
                            ['nom' => 'Sakassou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sakassou', 'code_officiel' => 'SP-SKS2'],
                            ['nom' => 'Diabo', 'type' => 'sous_prefecture', 'chef_lieu' => 'Diabo', 'code_officiel' => 'SP-DAB2'],
                            ['nom' => 'Sakassou', 'type' => 'commune', 'chef_lieu' => 'Sakassou', 'code_officiel' => 'CM-SKS2'],
                            ['nom' => 'Diabo', 'type' => 'commune', 'chef_lieu' => 'Diabo', 'code_officiel' => 'CM-DAB2'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Gbôklé',
                'type' => 'region',
                'chef_lieu' => 'Sassandra',
                'code_officiel' => 'RG-GBK2',
                'enfants' => [
                    [
                        'nom' => 'Sassandra',
                        'type' => 'departement',
                        'chef_lieu' => 'Sassandra',
                        'code_officiel' => 'DP-SSD',
                        'enfants' => [
                            ['nom' => 'Sassandra (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sassandra', 'code_officiel' => 'SP-SSD'],
                            ['nom' => 'Sago', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sago', 'code_officiel' => 'SP-SGO'],
                            ['nom' => 'Sassandra', 'type' => 'commune', 'chef_lieu' => 'Sassandra', 'code_officiel' => 'CM-SSD'],
                        ],
                    ],
                    [
                        'nom' => 'Fresco',
                        'type' => 'departement',
                        'chef_lieu' => 'Fresco',
                        'code_officiel' => 'DP-FRS',
                        'enfants' => [
                            ['nom' => 'Fresco (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Fresco', 'code_officiel' => 'SP-FRS'],
                            ['nom' => 'Grihiri', 'type' => 'sous_prefecture', 'chef_lieu' => 'Grihiri', 'code_officiel' => 'SP-GRH'],
                            ['nom' => 'Fresco', 'type' => 'commune', 'chef_lieu' => 'Fresco', 'code_officiel' => 'CM-FRS'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Gôh',
                'type' => 'region',
                'chef_lieu' => 'Gagnoa',
                'code_officiel' => 'RG-GOH',
                'enfants' => [
                    [
                        'nom' => 'Gagnoa',
                        'type' => 'departement',
                        'chef_lieu' => 'Gagnoa',
                        'code_officiel' => 'DP-GGN',
                        'enfants' => [
                            ['nom' => 'Gagnoa (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Gagnoa', 'code_officiel' => 'SP-GGN'],
                            ['nom' => 'Ouragahio', 'type' => 'sous_prefecture', 'chef_lieu' => 'Ouragahio', 'code_officiel' => 'SP-ORG'],
                            ['nom' => 'Bayota', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bayota', 'code_officiel' => 'SP-BYT'],
                            ['nom' => 'Guibéroua', 'type' => 'sous_prefecture', 'chef_lieu' => 'Guibéroua', 'code_officiel' => 'SP-GBR'],
                            ['nom' => 'Gagnoa', 'type' => 'commune', 'chef_lieu' => 'Gagnoa', 'code_officiel' => 'CM-GGN'],
                            ['nom' => 'Ouragahio', 'type' => 'commune', 'chef_lieu' => 'Ouragahio', 'code_officiel' => 'CM-ORG'],
                            ['nom' => 'Guibéroua', 'type' => 'commune', 'chef_lieu' => 'Guibéroua', 'code_officiel' => 'CM-GBR'],
                        ],
                    ],
                    [
                        'nom' => 'Oumé',
                        'type' => 'departement',
                        'chef_lieu' => 'Oumé',
                        'code_officiel' => 'DP-OME',
                        'enfants' => [
                            ['nom' => 'Oumé (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Oumé', 'code_officiel' => 'SP-OME'],
                            ['nom' => 'Diégonéfla', 'type' => 'sous_prefecture', 'chef_lieu' => 'Diégonéfla', 'code_officiel' => 'SP-DGN'],
                            ['nom' => 'Oumé', 'type' => 'commune', 'chef_lieu' => 'Oumé', 'code_officiel' => 'CM-OME'],
                            ['nom' => 'Diégonéfla', 'type' => 'commune', 'chef_lieu' => 'Diégonéfla', 'code_officiel' => 'CM-DGN'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Gontougo',
                'type' => 'region',
                'chef_lieu' => 'Bondoukou',
                'code_officiel' => 'RG-GNT',
                'enfants' => [
                    [
                        'nom' => 'Bondoukou',
                        'type' => 'departement',
                        'chef_lieu' => 'Bondoukou',
                        'code_officiel' => 'DP-BDK2',
                        'enfants' => [
                            ['nom' => 'Bondoukou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bondoukou', 'code_officiel' => 'SP-BDK2'],
                            ['nom' => 'Bondoukou', 'type' => 'commune', 'chef_lieu' => 'Bondoukou', 'code_officiel' => 'CM-BDK2'],
                        ],
                    ],
                    [
                        'nom' => 'Sandégué',
                        'type' => 'departement',
                        'chef_lieu' => 'Sandégué',
                        'code_officiel' => 'DP-SDG',
                        'enfants' => [
                            ['nom' => 'Sandégué (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sandégué', 'code_officiel' => 'SP-SDG'],
                            ['nom' => 'Sandégué', 'type' => 'commune', 'chef_lieu' => 'Sandégué', 'code_officiel' => 'CM-SDG'],
                        ],
                    ],
                    [
                        'nom' => 'Tanda',
                        'type' => 'departement',
                        'chef_lieu' => 'Tanda',
                        'code_officiel' => 'DP-TND',
                        'enfants' => [
                            ['nom' => 'Tanda (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tanda', 'code_officiel' => 'SP-TND'],
                            ['nom' => 'Tanda', 'type' => 'commune', 'chef_lieu' => 'Tanda', 'code_officiel' => 'CM-TND'],
                        ],
                    ],
                    [
                        'nom' => 'Transua',
                        'type' => 'departement',
                        'chef_lieu' => 'Transua',
                        'code_officiel' => 'DP-TRS',
                        'enfants' => [
                            ['nom' => 'Transua (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Transua', 'code_officiel' => 'SP-TRS'],
                            ['nom' => 'Transua', 'type' => 'commune', 'chef_lieu' => 'Transua', 'code_officiel' => 'CM-TRS'],
                        ],
                    ],
                    [
                        'nom' => 'Koun-Fao',
                        'type' => 'departement',
                        'chef_lieu' => 'Koun-Fao',
                        'code_officiel' => 'DP-KFO',
                        'enfants' => [
                            ['nom' => 'Koun-Fao (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Koun-Fao', 'code_officiel' => 'SP-KFO'],
                            ['nom' => 'Kouassi-Datékro', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kouassi-Datékro', 'code_officiel' => 'SP-KDT'],
                            ['nom' => 'Koun-Fao', 'type' => 'commune', 'chef_lieu' => 'Koun-Fao', 'code_officiel' => 'CM-KFO'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Grands Ponts',
                'type' => 'region',
                'chef_lieu' => 'Dabou',
                'code_officiel' => 'RG-GPT',
                'enfants' => [
                    [
                        'nom' => 'Dabou',
                        'type' => 'departement',
                        'chef_lieu' => 'Dabou',
                        'code_officiel' => 'DP-DAB2',
                        'enfants' => [
                            ['nom' => 'Dabou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Dabou', 'code_officiel' => 'SP-DAB2'],
                            ['nom' => 'Toupah', 'type' => 'sous_prefecture', 'chef_lieu' => 'Toupah', 'code_officiel' => 'SP-TPH'],
                            ['nom' => 'Lopou', 'type' => 'sous_prefecture', 'chef_lieu' => 'Lopou', 'code_officiel' => 'SP-LPV'],
                            ['nom' => 'Dabou', 'type' => 'commune', 'chef_lieu' => 'Dabou', 'code_officiel' => 'CM-DAB2'],
                        ],
                    ],
                    [
                        'nom' => 'Grand-Lahou',
                        'type' => 'departement',
                        'chef_lieu' => 'Grand-Lahou',
                        'code_officiel' => 'DP-GLH2',
                        'enfants' => [
                            ['nom' => 'Grand-Lahou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Grand-Lahou', 'code_officiel' => 'SP-GLH2'],
                            ['nom' => 'Grand-Lahou', 'type' => 'commune', 'chef_lieu' => 'Grand-Lahou', 'code_officiel' => 'CM-GLH2'],
                        ],
                    ],
                    [
                        'nom' => 'Jacqueville',
                        'type' => 'departement',
                        'chef_lieu' => 'Jacqueville',
                        'code_officiel' => 'DP-JCV2',
                        'enfants' => [
                            ['nom' => 'Jacqueville (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Jacqueville', 'code_officiel' => 'SP-JCV2'],
                            ['nom' => 'Jacqueville', 'type' => 'commune', 'chef_lieu' => 'Jacqueville', 'code_officiel' => 'CM-JCV2'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Guémon',
                'type' => 'region',
                'chef_lieu' => 'Duékoué',
                'code_officiel' => 'RG-GMN',
                'enfants' => [
                    [
                        'nom' => 'Duékoué',
                        'type' => 'departement',
                        'chef_lieu' => 'Duékoué',
                        'code_officiel' => 'DP-DKÉ',
                        'enfants' => [
                            ['nom' => 'Duékoué (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Duékoué', 'code_officiel' => 'SP-DKÉ'],
                            ['nom' => 'Bagohouo', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bagohouo', 'code_officiel' => 'SP-BGH'],
                            ['nom' => 'Duékoué', 'type' => 'commune', 'chef_lieu' => 'Duékoué', 'code_officiel' => 'CM-DKÉ'],
                        ],
                    ],
                    [
                        'nom' => 'Bangolo',
                        'type' => 'departement',
                        'chef_lieu' => 'Bangolo',
                        'code_officiel' => 'DP-BNG',
                        'enfants' => [
                            ['nom' => 'Bangolo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bangolo', 'code_officiel' => 'SP-BNG'],
                            ['nom' => 'Bangolo', 'type' => 'commune', 'chef_lieu' => 'Bangolo', 'code_officiel' => 'CM-BNG'],
                        ],
                    ],
                    [
                        'nom' => 'Facobly',
                        'type' => 'departement',
                        'chef_lieu' => 'Facobly',
                        'code_officiel' => 'DP-FCB',
                        'enfants' => [
                            ['nom' => 'Facobly (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Facobly', 'code_officiel' => 'SP-FCB'],
                            ['nom' => 'Facobly', 'type' => 'commune', 'chef_lieu' => 'Facobly', 'code_officiel' => 'CM-FCB'],
                        ],
                    ],
                    [
                        'nom' => 'Kouibly',
                        'type' => 'departement',
                        'chef_lieu' => 'Kouibly',
                        'code_officiel' => 'DP-KBL',
                        'enfants' => [
                            ['nom' => 'Kouibly (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kouibly', 'code_officiel' => 'SP-KBL'],
                            ['nom' => 'Kouibly', 'type' => 'commune', 'chef_lieu' => 'Kouibly', 'code_officiel' => 'CM-KBL'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Hambol',
                'type' => 'region',
                'chef_lieu' => 'Katiola',
                'code_officiel' => 'RG-HBL',
                'enfants' => [
                    [
                        'nom' => 'Katiola',
                        'type' => 'departement',
                        'chef_lieu' => 'Katiola',
                        'code_officiel' => 'DP-KTL',
                        'enfants' => [
                            ['nom' => 'Katiola (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Katiola', 'code_officiel' => 'SP-KTL'],
                            ['nom' => 'Fronan', 'type' => 'sous_prefecture', 'chef_lieu' => 'Fronan', 'code_officiel' => 'SP-FRN'],
                            ['nom' => 'Katiola', 'type' => 'commune', 'chef_lieu' => 'Katiola', 'code_officiel' => 'CM-KTL'],
                        ],
                    ],
                    [
                        'nom' => 'Dabakala',
                        'type' => 'departement',
                        'chef_lieu' => 'Dabakala',
                        'code_officiel' => 'DP-DBK',
                        'enfants' => [
                            ['nom' => 'Dabakala (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Dabakala', 'code_officiel' => 'SP-DBK'],
                            ['nom' => 'Dabakala', 'type' => 'commune', 'chef_lieu' => 'Dabakala', 'code_officiel' => 'CM-DBK'],
                        ],
                    ],
                    [
                        'nom' => 'Niakaramandougou',
                        'type' => 'departement',
                        'chef_lieu' => 'Niakaramandougou',
                        'code_officiel' => 'DP-NKR',
                        'enfants' => [
                            ['nom' => 'Niakaramandougou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Niakaramandougou', 'code_officiel' => 'SP-NKR'],
                            ['nom' => 'Tafiré', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tafiré', 'code_officiel' => 'SP-TFR'],
                            ['nom' => 'Niakaramandougou', 'type' => 'commune', 'chef_lieu' => 'Niakaramandougou', 'code_officiel' => 'CM-NKR'],
                            ['nom' => 'Tafiré', 'type' => 'commune', 'chef_lieu' => 'Tafiré', 'code_officiel' => 'CM-TFR'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Haut-Sassandra',
                'type' => 'region',
                'chef_lieu' => 'Daloa',
                'code_officiel' => 'RG-HSS',
                'enfants' => [
                    [
                        'nom' => 'Daloa',
                        'type' => 'departement',
                        'chef_lieu' => 'Daloa',
                        'code_officiel' => 'DP-DLA',
                        'enfants' => [
                            ['nom' => 'Daloa (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Daloa', 'code_officiel' => 'SP-DLA'],
                            ['nom' => 'Bediala', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bediala', 'code_officiel' => 'SP-BDL'],
                            ['nom' => 'Gonaté', 'type' => 'sous_prefecture', 'chef_lieu' => 'Gonaté', 'code_officiel' => 'SP-GNT'],
                            ['nom' => 'Daloa', 'type' => 'commune', 'chef_lieu' => 'Daloa', 'code_officiel' => 'CM-DLA'],
                        ],
                    ],
                    [
                        'nom' => 'Issia',
                        'type' => 'departement',
                        'chef_lieu' => 'Issia',
                        'code_officiel' => 'DP-ISS',
                        'enfants' => [
                            ['nom' => 'Issia (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Issia', 'code_officiel' => 'SP-ISS'],
                            ['nom' => 'Issia', 'type' => 'commune', 'chef_lieu' => 'Issia', 'code_officiel' => 'CM-ISS'],
                        ],
                    ],
                    [
                        'nom' => 'Vavoua',
                        'type' => 'departement',
                        'chef_lieu' => 'Vavoua',
                        'code_officiel' => 'DP-VVV',
                        'enfants' => [
                            ['nom' => 'Vavoua (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Vavoua', 'code_officiel' => 'SP-VVV'],
                            ['nom' => 'Vavoua', 'type' => 'commune', 'chef_lieu' => 'Vavoua', 'code_officiel' => 'CM-VVV'],
                        ],
                    ],
                    [
                        'nom' => 'Zoukougbeu',
                        'type' => 'departement',
                        'chef_lieu' => 'Zoukougbeu',
                        'code_officiel' => 'DP-ZKB',
                        'enfants' => [
                            ['nom' => 'Zoukougbeu (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Zoukougbeu', 'code_officiel' => 'SP-ZKB'],
                            ['nom' => 'Zoukougbeu', 'type' => 'commune', 'chef_lieu' => 'Zoukougbeu', 'code_officiel' => 'CM-ZKB'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Iffou',
                'type' => 'region',
                'chef_lieu' => 'Daoukro',
                'code_officiel' => 'RG-IFF',
                'enfants' => [
                    [
                        'nom' => 'Daoukro',
                        'type' => 'departement',
                        'chef_lieu' => 'Daoukro',
                        'code_officiel' => 'DP-DKR',
                        'enfants' => [
                            ['nom' => 'Daoukro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Daoukro', 'code_officiel' => 'SP-DKR'],
                            ['nom' => 'Ettrokro', 'type' => 'sous_prefecture', 'chef_lieu' => 'Ettrokro', 'code_officiel' => 'SP-ETK'],
                            ['nom' => 'Daoukro', 'type' => 'commune', 'chef_lieu' => 'Daoukro', 'code_officiel' => 'CM-DKR'],
                        ],
                    ],
                    [
                        'nom' => 'M\'Bahiakro',
                        'type' => 'departement',
                        'chef_lieu' => 'M\'Bahiakro',
                        'code_officiel' => 'DP-MBH',
                        'enfants' => [
                            ['nom' => 'M\'Bahiakro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'M\'Bahiakro', 'code_officiel' => 'SP-MBH'],
                            ['nom' => 'M\'Bahiakro', 'type' => 'commune', 'chef_lieu' => 'M\'Bahiakro', 'code_officiel' => 'CM-MBH'],
                        ],
                    ],
                    [
                        'nom' => 'Prikro',
                        'type' => 'departement',
                        'chef_lieu' => 'Prikro',
                        'code_officiel' => 'DP-PRK',
                        'enfants' => [
                            ['nom' => 'Prikro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Prikro', 'code_officiel' => 'SP-PRK'],
                            ['nom' => 'Prikro', 'type' => 'commune', 'chef_lieu' => 'Prikro', 'code_officiel' => 'CM-PRK'],
                        ],
                    ],
                    [
                        'nom' => 'Ouellé',
                        'type' => 'departement',
                        'chef_lieu' => 'Ouellé',
                        'code_officiel' => 'DP-OLL',
                        'enfants' => [
                            ['nom' => 'Ouellé (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Ouellé', 'code_officiel' => 'SP-OLL'],
                            ['nom' => 'Ouellé', 'type' => 'commune', 'chef_lieu' => 'Ouellé', 'code_officiel' => 'CM-OLL'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Indénié-Djuablin',
                'type' => 'region',
                'chef_lieu' => 'Abengourou',
                'code_officiel' => 'RG-IND',
                'enfants' => [
                    [
                        'nom' => 'Abengourou',
                        'type' => 'departement',
                        'chef_lieu' => 'Abengourou',
                        'code_officiel' => 'DP-ABG',
                        'enfants' => [
                            ['nom' => 'Abengourou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Abengourou', 'code_officiel' => 'SP-ABG'],
                            ['nom' => 'Niablé', 'type' => 'sous_prefecture', 'chef_lieu' => 'Niablé', 'code_officiel' => 'SP-NBL'],
                            ['nom' => 'Amélékia', 'type' => 'sous_prefecture', 'chef_lieu' => 'Amélékia', 'code_officiel' => 'SP-AML'],
                            ['nom' => 'Abengourou', 'type' => 'commune', 'chef_lieu' => 'Abengourou', 'code_officiel' => 'CM-ABG'],
                            ['nom' => 'Niablé', 'type' => 'commune', 'chef_lieu' => 'Niablé', 'code_officiel' => 'CM-NBL'],
                        ],
                    ],
                    [
                        'nom' => 'Agnibilékrou',
                        'type' => 'departement',
                        'chef_lieu' => 'Agnibilékrou',
                        'code_officiel' => 'DP-AGK',
                        'enfants' => [
                            ['nom' => 'Agnibilékrou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Agnibilékrou', 'code_officiel' => 'SP-AGK'],
                            ['nom' => 'Agnibilékrou', 'type' => 'commune', 'chef_lieu' => 'Agnibilékrou', 'code_officiel' => 'CM-AGK'],
                        ],
                    ],
                    [
                        'nom' => 'Bettié',
                        'type' => 'departement',
                        'chef_lieu' => 'Bettié',
                        'code_officiel' => 'DP-BTT',
                        'enfants' => [
                            ['nom' => 'Bettié (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bettié', 'code_officiel' => 'SP-BTT'],
                            ['nom' => 'Bettié', 'type' => 'commune', 'chef_lieu' => 'Bettié', 'code_officiel' => 'CM-BTT'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Kabadougou',
                'type' => 'region',
                'chef_lieu' => 'Odienné',
                'code_officiel' => 'RG-KBD',
                'enfants' => [
                    [
                        'nom' => 'Odienné',
                        'type' => 'departement',
                        'chef_lieu' => 'Odienné',
                        'code_officiel' => 'DP-ODN',
                        'enfants' => [
                            ['nom' => 'Odienné (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Odienné', 'code_officiel' => 'SP-ODN'],
                            ['nom' => 'Seydougou', 'type' => 'sous_prefecture', 'chef_lieu' => 'Seydougou', 'code_officiel' => 'SP-SYD'],
                            ['nom' => 'Odienné', 'type' => 'commune', 'chef_lieu' => 'Odienné', 'code_officiel' => 'CM-ODN'],
                        ],
                    ],
                    [
                        'nom' => 'Madinani',
                        'type' => 'departement',
                        'chef_lieu' => 'Madinani',
                        'code_officiel' => 'DP-MDN',
                        'enfants' => [
                            ['nom' => 'Madinani (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Madinani', 'code_officiel' => 'SP-MDN'],
                            ['nom' => 'Madinani', 'type' => 'commune', 'chef_lieu' => 'Madinani', 'code_officiel' => 'CM-MDN'],
                        ],
                    ],
                    [
                        'nom' => 'Seguelon',
                        'type' => 'departement',
                        'chef_lieu' => 'Seguelon',
                        'code_officiel' => 'DP-SGL',
                        'enfants' => [
                            ['nom' => 'Seguelon (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Seguelon', 'code_officiel' => 'SP-SGL'],
                            ['nom' => 'Seguelon', 'type' => 'commune', 'chef_lieu' => 'Seguelon', 'code_officiel' => 'CM-SGL'],
                        ],
                    ],
                    [
                        'nom' => 'Samatiguila',
                        'type' => 'departement',
                        'chef_lieu' => 'Samatiguila',
                        'code_officiel' => 'DP-SMT',
                        'enfants' => [
                            ['nom' => 'Samatiguila (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Samatiguila', 'code_officiel' => 'SP-SMT'],
                            ['nom' => 'Samatiguila', 'type' => 'commune', 'chef_lieu' => 'Samatiguila', 'code_officiel' => 'CM-SMT'],
                        ],
                    ],
                    [
                        'nom' => 'Gbéléban',
                        'type' => 'departement',
                        'chef_lieu' => 'Gbéléban',
                        'code_officiel' => 'DP-GBL',
                        'enfants' => [
                            ['nom' => 'Gbéléban (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Gbéléban', 'code_officiel' => 'SP-GBL'],
                            ['nom' => 'Gbéléban', 'type' => 'commune', 'chef_lieu' => 'Gbéléban', 'code_officiel' => 'CM-GBL'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'La Mé',
                'type' => 'region',
                'chef_lieu' => 'Adzopé',
                'code_officiel' => 'RG-LME',
                'enfants' => [
                    [
                        'nom' => 'Adzopé',
                        'type' => 'departement',
                        'chef_lieu' => 'Adzopé',
                        'code_officiel' => 'DP-ADZ',
                        'enfants' => [
                            ['nom' => 'Adzopé (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Adzopé', 'code_officiel' => 'SP-ADZ'],
                            ['nom' => 'Afféry', 'type' => 'sous_prefecture', 'chef_lieu' => 'Afféry', 'code_officiel' => 'SP-AFF'],
                            ['nom' => 'Agou', 'type' => 'sous_prefecture', 'chef_lieu' => 'Agou', 'code_officiel' => 'SP-AGO'],
                            ['nom' => 'Adzopé', 'type' => 'commune', 'chef_lieu' => 'Adzopé', 'code_officiel' => 'CM-ADZ'],
                            ['nom' => 'Afféry', 'type' => 'commune', 'chef_lieu' => 'Afféry', 'code_officiel' => 'CM-AFF'],
                        ],
                    ],
                    [
                        'nom' => 'Akoupé',
                        'type' => 'departement',
                        'chef_lieu' => 'Akoupé',
                        'code_officiel' => 'DP-AKP',
                        'enfants' => [
                            ['nom' => 'Akoupé (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Akoupé', 'code_officiel' => 'SP-AKP'],
                            ['nom' => 'Akoupé', 'type' => 'commune', 'chef_lieu' => 'Akoupé', 'code_officiel' => 'CM-AKP'],
                        ],
                    ],
                    [
                        'nom' => 'Alépé',
                        'type' => 'departement',
                        'chef_lieu' => 'Alépé',
                        'code_officiel' => 'DP-ALP',
                        'enfants' => [
                            ['nom' => 'Alépé (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Alépé', 'code_officiel' => 'SP-ALP'],
                            ['nom' => 'Alépé', 'type' => 'commune', 'chef_lieu' => 'Alépé', 'code_officiel' => 'CM-ALP'],
                        ],
                    ],
                    [
                        'nom' => 'Yakassé-Attobrou',
                        'type' => 'departement',
                        'chef_lieu' => 'Yakassé-Attobrou',
                        'code_officiel' => 'DP-YKS',
                        'enfants' => [
                            ['nom' => 'Yakassé-Attobrou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Yakassé-Attobrou', 'code_officiel' => 'SP-YKS'],
                            ['nom' => 'Yakassé-Attobrou', 'type' => 'commune', 'chef_lieu' => 'Yakassé-Attobrou', 'code_officiel' => 'CM-YKS'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Lôh-Djiboua',
                'type' => 'region',
                'chef_lieu' => 'Divo',
                'code_officiel' => 'RG-LDJ',
                'enfants' => [
                    [
                        'nom' => 'Divo',
                        'type' => 'departement',
                        'chef_lieu' => 'Divo',
                        'code_officiel' => 'DP-DVO',
                        'enfants' => [
                            ['nom' => 'Divo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Divo', 'code_officiel' => 'SP-DVO'],
                            ['nom' => 'Zikisso', 'type' => 'sous_prefecture', 'chef_lieu' => 'Zikisso', 'code_officiel' => 'SP-ZKS'],
                            ['nom' => 'Divo', 'type' => 'commune', 'chef_lieu' => 'Divo', 'code_officiel' => 'CM-DVO'],
                            ['nom' => 'Zikisso', 'type' => 'commune', 'chef_lieu' => 'Zikisso', 'code_officiel' => 'CM-ZKS'],
                        ],
                    ],
                    [
                        'nom' => 'Lakota',
                        'type' => 'departement',
                        'chef_lieu' => 'Lakota',
                        'code_officiel' => 'DP-LKT',
                        'enfants' => [
                            ['nom' => 'Lakota (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Lakota', 'code_officiel' => 'SP-LKT'],
                            ['nom' => 'Lakota', 'type' => 'commune', 'chef_lieu' => 'Lakota', 'code_officiel' => 'CM-LKT'],
                        ],
                    ],
                    [
                        'nom' => 'Guitry',
                        'type' => 'departement',
                        'chef_lieu' => 'Guitry',
                        'code_officiel' => 'DP-GTR',
                        'enfants' => [
                            ['nom' => 'Guitry (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Guitry', 'code_officiel' => 'SP-GTR'],
                            ['nom' => 'Hiré', 'type' => 'sous_prefecture', 'chef_lieu' => 'Hiré', 'code_officiel' => 'SP-HRE'],
                            ['nom' => 'Guitry', 'type' => 'commune', 'chef_lieu' => 'Guitry', 'code_officiel' => 'CM-GTR'],
                            ['nom' => 'Hiré', 'type' => 'commune', 'chef_lieu' => 'Hiré', 'code_officiel' => 'CM-HRE'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Marahoué',
                'type' => 'region',
                'chef_lieu' => 'Bouaflé',
                'code_officiel' => 'RG-MRH',
                'enfants' => [
                    [
                        'nom' => 'Bouaflé',
                        'type' => 'departement',
                        'chef_lieu' => 'Bouaflé',
                        'code_officiel' => 'DP-BFL',
                        'enfants' => [
                            ['nom' => 'Bouaflé (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bouaflé', 'code_officiel' => 'SP-BFL'],
                            ['nom' => 'Bediala', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bediala', 'code_officiel' => 'SP-BDL2'],
                            ['nom' => 'Bouaflé', 'type' => 'commune', 'chef_lieu' => 'Bouaflé', 'code_officiel' => 'CM-BFL'],
                        ],
                    ],
                    [
                        'nom' => 'Sinfra',
                        'type' => 'departement',
                        'chef_lieu' => 'Sinfra',
                        'code_officiel' => 'DP-SFR',
                        'enfants' => [
                            ['nom' => 'Sinfra (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sinfra', 'code_officiel' => 'SP-SFR'],
                            ['nom' => 'Sinfra', 'type' => 'commune', 'chef_lieu' => 'Sinfra', 'code_officiel' => 'CM-SFR'],
                        ],
                    ],
                    [
                        'nom' => 'Zuénoula',
                        'type' => 'departement',
                        'chef_lieu' => 'Zuénoula',
                        'code_officiel' => 'DP-ZNL',
                        'enfants' => [
                            ['nom' => 'Zuénoula (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Zuénoula', 'code_officiel' => 'SP-ZNL'],
                            ['nom' => 'Zuénoula', 'type' => 'commune', 'chef_lieu' => 'Zuénoula', 'code_officiel' => 'CM-ZNL'],
                        ],
                    ],
                    [
                        'nom' => 'Bonon',
                        'type' => 'departement',
                        'chef_lieu' => 'Bonon',
                        'code_officiel' => 'DP-BNN',
                        'enfants' => [
                            ['nom' => 'Bonon (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bonon', 'code_officiel' => 'SP-BNN'],
                            ['nom' => 'Bonon', 'type' => 'commune', 'chef_lieu' => 'Bonon', 'code_officiel' => 'CM-BNN'],
                        ],
                    ],
                    [
                        'nom' => 'Gohitafla',
                        'type' => 'departement',
                        'chef_lieu' => 'Gohitafla',
                        'code_officiel' => 'DP-GHT',
                        'enfants' => [
                            ['nom' => 'Gohitafla (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Gohitafla', 'code_officiel' => 'SP-GHT'],
                            ['nom' => 'Gohitafla', 'type' => 'commune', 'chef_lieu' => 'Gohitafla', 'code_officiel' => 'CM-GHT'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Moronou',
                'type' => 'region',
                'chef_lieu' => 'Bongouanou',
                'code_officiel' => 'RG-MRN',
                'enfants' => [
                    [
                        'nom' => 'Bongouanou',
                        'type' => 'departement',
                        'chef_lieu' => 'Bongouanou',
                        'code_officiel' => 'DP-BGN',
                        'enfants' => [
                            ['nom' => 'Bongouanou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bongouanou', 'code_officiel' => 'SP-BGN'],
                            ['nom' => 'Assié-Kouamékro', 'type' => 'sous_prefecture', 'chef_lieu' => 'Assié-Kouamékro', 'code_officiel' => 'SP-ASK'],
                            ['nom' => 'Bongouanou', 'type' => 'commune', 'chef_lieu' => 'Bongouanou', 'code_officiel' => 'CM-BGN'],
                        ],
                    ],
                    [
                        'nom' => 'Arrah',
                        'type' => 'departement',
                        'chef_lieu' => 'Arrah',
                        'code_officiel' => 'DP-ARH',
                        'enfants' => [
                            ['nom' => 'Arrah (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Arrah', 'code_officiel' => 'SP-ARH'],
                            ['nom' => 'Arrah', 'type' => 'commune', 'chef_lieu' => 'Arrah', 'code_officiel' => 'CM-ARH'],
                        ],
                    ],
                    [
                        'nom' => 'M\'Batto',
                        'type' => 'departement',
                        'chef_lieu' => 'M\'Batto',
                        'code_officiel' => 'DP-MBT',
                        'enfants' => [
                            ['nom' => 'M\'Batto (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'M\'Batto', 'code_officiel' => 'SP-MBT'],
                            ['nom' => 'Anoumaba', 'type' => 'sous_prefecture', 'chef_lieu' => 'Anoumaba', 'code_officiel' => 'SP-ANM'],
                            ['nom' => 'M\'Batto', 'type' => 'commune', 'chef_lieu' => 'M\'Batto', 'code_officiel' => 'CM-MBT'],
                            ['nom' => 'Anoumaba', 'type' => 'commune', 'chef_lieu' => 'Anoumaba', 'code_officiel' => 'CM-ANM'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Nawa',
                'type' => 'region',
                'chef_lieu' => 'Soubré',
                'code_officiel' => 'RG-NWA',
                'enfants' => [
                    [
                        'nom' => 'Soubré',
                        'type' => 'departement',
                        'chef_lieu' => 'Soubré',
                        'code_officiel' => 'DP-SBR',
                        'enfants' => [
                            ['nom' => 'Soubré (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Soubré', 'code_officiel' => 'SP-SBR'],
                            ['nom' => 'Okrouyo', 'type' => 'sous_prefecture', 'chef_lieu' => 'Okrouyo', 'code_officiel' => 'SP-OKR'],
                            ['nom' => 'Soubré', 'type' => 'commune', 'chef_lieu' => 'Soubré', 'code_officiel' => 'CM-SBR'],
                        ],
                    ],
                    [
                        'nom' => 'Buyo',
                        'type' => 'departement',
                        'chef_lieu' => 'Buyo',
                        'code_officiel' => 'DP-BYO',
                        'enfants' => [
                            ['nom' => 'Buyo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Buyo', 'code_officiel' => 'SP-BYO'],
                            ['nom' => 'Buyo', 'type' => 'commune', 'chef_lieu' => 'Buyo', 'code_officiel' => 'CM-BYO'],
                        ],
                    ],
                    [
                        'nom' => 'Guéyo',
                        'type' => 'departement',
                        'chef_lieu' => 'Guéyo',
                        'code_officiel' => 'DP-GYO',
                        'enfants' => [
                            ['nom' => 'Guéyo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Guéyo', 'code_officiel' => 'SP-GYO'],
                            ['nom' => 'Guéyo', 'type' => 'commune', 'chef_lieu' => 'Guéyo', 'code_officiel' => 'CM-GYO'],
                        ],
                    ],
                    [
                        'nom' => 'Méagui',
                        'type' => 'departement',
                        'chef_lieu' => 'Méagui',
                        'code_officiel' => 'DP-MGV',
                        'enfants' => [
                            ['nom' => 'Méagui (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Méagui', 'code_officiel' => 'SP-MGV'],
                            ['nom' => 'Grand-Zattry', 'type' => 'sous_prefecture', 'chef_lieu' => 'Grand-Zattry', 'code_officiel' => 'SP-GZT'],
                            ['nom' => 'Méagui', 'type' => 'commune', 'chef_lieu' => 'Méagui', 'code_officiel' => 'CM-MGV'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'N\'Zi',
                'type' => 'region',
                'chef_lieu' => 'Dimbokro',
                'code_officiel' => 'RG-NZI',
                'enfants' => [
                    [
                        'nom' => 'Dimbokro',
                        'type' => 'departement',
                        'chef_lieu' => 'Dimbokro',
                        'code_officiel' => 'DP-DMB',
                        'enfants' => [
                            ['nom' => 'Dimbokro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Dimbokro', 'code_officiel' => 'SP-DMB'],
                            ['nom' => 'N\'Gattakro', 'type' => 'sous_prefecture', 'chef_lieu' => 'N\'Gattakro', 'code_officiel' => 'SP-NGT'],
                            ['nom' => 'Dimbokro', 'type' => 'commune', 'chef_lieu' => 'Dimbokro', 'code_officiel' => 'CM-DMB'],
                        ],
                    ],
                    [
                        'nom' => 'Bocanda',
                        'type' => 'departement',
                        'chef_lieu' => 'Bocanda',
                        'code_officiel' => 'DP-BCD',
                        'enfants' => [
                            ['nom' => 'Bocanda (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bocanda', 'code_officiel' => 'SP-BCD'],
                            ['nom' => 'Bocanda', 'type' => 'commune', 'chef_lieu' => 'Bocanda', 'code_officiel' => 'CM-BCD'],
                        ],
                    ],
                    [
                        'nom' => 'Kouassi-Kouassikro',
                        'type' => 'departement',
                        'chef_lieu' => 'Kouassi-Kouassikro',
                        'code_officiel' => 'DP-KKK',
                        'enfants' => [
                            ['nom' => 'Kouassi-Kouassikro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kouassi-Kouassikro', 'code_officiel' => 'SP-KKK'],
                            ['nom' => 'Kouassi-Kouassikro', 'type' => 'commune', 'chef_lieu' => 'Kouassi-Kouassikro', 'code_officiel' => 'CM-KKK'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Poro',
                'type' => 'region',
                'chef_lieu' => 'Korhogo',
                'code_officiel' => 'RG-PRO',
                'enfants' => [
                    [
                        'nom' => 'Korhogo',
                        'type' => 'departement',
                        'chef_lieu' => 'Korhogo',
                        'code_officiel' => 'DP-KRH',
                        'enfants' => [
                            ['nom' => 'Korhogo (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Korhogo', 'code_officiel' => 'SP-KRH'],
                            ['nom' => 'Niofoin', 'type' => 'sous_prefecture', 'chef_lieu' => 'Niofoin', 'code_officiel' => 'SP-NFN'],
                            ['nom' => 'Tioroniaradougou', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tioroniaradougou', 'code_officiel' => 'SP-TRN'],
                            ['nom' => 'Korhogo', 'type' => 'commune', 'chef_lieu' => 'Korhogo', 'code_officiel' => 'CM-KRH'],
                        ],
                    ],
                    [
                        'nom' => 'Dikodougou',
                        'type' => 'departement',
                        'chef_lieu' => 'Dikodougou',
                        'code_officiel' => 'DP-DKD',
                        'enfants' => [
                            ['nom' => 'Dikodougou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Dikodougou', 'code_officiel' => 'SP-DKD'],
                            ['nom' => 'Dikodougou', 'type' => 'commune', 'chef_lieu' => 'Dikodougou', 'code_officiel' => 'CM-DKD'],
                        ],
                    ],
                    [
                        'nom' => 'M\'Bengué',
                        'type' => 'departement',
                        'chef_lieu' => 'M\'Bengué',
                        'code_officiel' => 'DP-MBG',
                        'enfants' => [
                            ['nom' => 'M\'Bengué (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'M\'Bengué', 'code_officiel' => 'SP-MBG'],
                            ['nom' => 'M\'Bengué', 'type' => 'commune', 'chef_lieu' => 'M\'Bengué', 'code_officiel' => 'CM-MBG'],
                        ],
                    ],
                    [
                        'nom' => 'Sinématiali',
                        'type' => 'departement',
                        'chef_lieu' => 'Sinématiali',
                        'code_officiel' => 'DP-SNT',
                        'enfants' => [
                            ['nom' => 'Sinématiali (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sinématiali', 'code_officiel' => 'SP-SNT'],
                            ['nom' => 'Sinématiali', 'type' => 'commune', 'chef_lieu' => 'Sinématiali', 'code_officiel' => 'CM-SNT'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'San-Pédro',
                'type' => 'region',
                'chef_lieu' => 'San-Pédro',
                'code_officiel' => 'RG-SPD',
                'enfants' => [
                    [
                        'nom' => 'San-Pédro',
                        'type' => 'departement',
                        'chef_lieu' => 'San-Pédro',
                        'code_officiel' => 'DP-SPD',
                        'enfants' => [
                            ['nom' => 'San-Pédro (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'San-Pédro', 'code_officiel' => 'SP-SPD'],
                            ['nom' => 'Doba', 'type' => 'sous_prefecture', 'chef_lieu' => 'Doba', 'code_officiel' => 'SP-DBA'],
                            ['nom' => 'San-Pédro', 'type' => 'commune', 'chef_lieu' => 'San-Pédro', 'code_officiel' => 'CM-SPD'],
                        ],
                    ],
                    [
                        'nom' => 'Tabou',
                        'type' => 'departement',
                        'chef_lieu' => 'Tabou',
                        'code_officiel' => 'DP-TBU',
                        'enfants' => [
                            ['nom' => 'Tabou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tabou', 'code_officiel' => 'SP-TBU'],
                            ['nom' => 'Grand-Béréby', 'type' => 'sous_prefecture', 'chef_lieu' => 'Grand-Béréby', 'code_officiel' => 'SP-GBY'],
                            ['nom' => 'Grabo', 'type' => 'sous_prefecture', 'chef_lieu' => 'Grabo', 'code_officiel' => 'SP-GRB'],
                            ['nom' => 'Tabou', 'type' => 'commune', 'chef_lieu' => 'Tabou', 'code_officiel' => 'CM-TBU'],
                            ['nom' => 'Grand-Béréby', 'type' => 'commune', 'chef_lieu' => 'Grand-Béréby', 'code_officiel' => 'CM-GBY'],
                            ['nom' => 'Grabo', 'type' => 'commune', 'chef_lieu' => 'Grabo', 'code_officiel' => 'CM-GRB'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Sud-Comoé',
                'type' => 'region',
                'chef_lieu' => 'Aboisso',
                'code_officiel' => 'RG-SCM',
                'enfants' => [
                    [
                        'nom' => 'Aboisso',
                        'type' => 'departement',
                        'chef_lieu' => 'Aboisso',
                        'code_officiel' => 'DP-ABS',
                        'enfants' => [
                            ['nom' => 'Aboisso (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Aboisso', 'code_officiel' => 'SP-ABS'],
                            ['nom' => 'Maféré', 'type' => 'sous_prefecture', 'chef_lieu' => 'Maféré', 'code_officiel' => 'SP-MFR'],
                            ['nom' => 'Aboisso', 'type' => 'commune', 'chef_lieu' => 'Aboisso', 'code_officiel' => 'CM-ABS'],
                            ['nom' => 'Maféré', 'type' => 'commune', 'chef_lieu' => 'Maféré', 'code_officiel' => 'CM-MFR'],
                        ],
                    ],
                    [
                        'nom' => 'Adiaké',
                        'type' => 'departement',
                        'chef_lieu' => 'Adiaké',
                        'code_officiel' => 'DP-ADK',
                        'enfants' => [
                            ['nom' => 'Adiaké (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Adiaké', 'code_officiel' => 'SP-ADK'],
                            ['nom' => 'Adiaké', 'type' => 'commune', 'chef_lieu' => 'Adiaké', 'code_officiel' => 'CM-ADK'],
                        ],
                    ],
                    [
                        'nom' => 'Grand-Bassam',
                        'type' => 'departement',
                        'chef_lieu' => 'Grand-Bassam',
                        'code_officiel' => 'DP-GBS',
                        'enfants' => [
                            ['nom' => 'Grand-Bassam (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Grand-Bassam', 'code_officiel' => 'SP-GBS'],
                            ['nom' => 'Bonoua', 'type' => 'sous_prefecture', 'chef_lieu' => 'Bonoua', 'code_officiel' => 'SP-BNU'],
                            ['nom' => 'Grand-Bassam', 'type' => 'commune', 'chef_lieu' => 'Grand-Bassam', 'code_officiel' => 'CM-GBS'],
                            ['nom' => 'Bonoua', 'type' => 'commune', 'chef_lieu' => 'Bonoua', 'code_officiel' => 'CM-BNU'],
                        ],
                    ],
                    [
                        'nom' => 'Tiapoum',
                        'type' => 'departement',
                        'chef_lieu' => 'Tiapoum',
                        'code_officiel' => 'DP-TPM',
                        'enfants' => [
                            ['nom' => 'Tiapoum (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Tiapoum', 'code_officiel' => 'SP-TPM'],
                            ['nom' => 'Tiapoum', 'type' => 'commune', 'chef_lieu' => 'Tiapoum', 'code_officiel' => 'CM-TPM'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Tchologo',
                'type' => 'region',
                'chef_lieu' => 'Ferkessédougou',
                'code_officiel' => 'RG-TCH',
                'enfants' => [
                    [
                        'nom' => 'Ferkessédougou',
                        'type' => 'departement',
                        'chef_lieu' => 'Ferkessédougou',
                        'code_officiel' => 'DP-FRK',
                        'enfants' => [
                            ['nom' => 'Ferkessédougou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Ferkessédougou', 'code_officiel' => 'SP-FRK'],
                            ['nom' => 'Togoniéré', 'type' => 'sous_prefecture', 'chef_lieu' => 'Togoniéré', 'code_officiel' => 'SP-TGN'],
                            ['nom' => 'Ferkessédougou', 'type' => 'commune', 'chef_lieu' => 'Ferkessédougou', 'code_officiel' => 'CM-FRK'],
                        ],
                    ],
                    [
                        'nom' => 'Kong',
                        'type' => 'departement',
                        'chef_lieu' => 'Kong',
                        'code_officiel' => 'DP-KNG',
                        'enfants' => [
                            ['nom' => 'Kong (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kong', 'code_officiel' => 'SP-KNG'],
                            ['nom' => 'Kong', 'type' => 'commune', 'chef_lieu' => 'Kong', 'code_officiel' => 'CM-KNG'],
                        ],
                    ],
                    [
                        'nom' => 'Ouangolodougou',
                        'type' => 'departement',
                        'chef_lieu' => 'Ouangolodougou',
                        'code_officiel' => 'DP-ONG',
                        'enfants' => [
                            ['nom' => 'Ouangolodougou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Ouangolodougou', 'code_officiel' => 'SP-ONG'],
                            ['nom' => 'Kaouara', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kaouara', 'code_officiel' => 'SP-KWR'],
                            ['nom' => 'Ouangolodougou', 'type' => 'commune', 'chef_lieu' => 'Ouangolodougou', 'code_officiel' => 'CM-ONG'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Tonkpi',
                'type' => 'region',
                'chef_lieu' => 'Man',
                'code_officiel' => 'RG-TNK',
                'enfants' => [
                    [
                        'nom' => 'Man',
                        'type' => 'departement',
                        'chef_lieu' => 'Man',
                        'code_officiel' => 'DP-MAN',
                        'enfants' => [
                            ['nom' => 'Man (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Man', 'code_officiel' => 'SP-MAN'],
                            ['nom' => 'Logoualé', 'type' => 'sous_prefecture', 'chef_lieu' => 'Logoualé', 'code_officiel' => 'SP-LGL'],
                            ['nom' => 'Sangouiné', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sangouiné', 'code_officiel' => 'SP-SGN2'],
                            ['nom' => 'Man', 'type' => 'commune', 'chef_lieu' => 'Man', 'code_officiel' => 'CM-MAN'],
                            ['nom' => 'Logoualé', 'type' => 'commune', 'chef_lieu' => 'Logoualé', 'code_officiel' => 'CM-LGL'],
                        ],
                    ],
                    [
                        'nom' => 'Danané',
                        'type' => 'departement',
                        'chef_lieu' => 'Danané',
                        'code_officiel' => 'DP-DNN',
                        'enfants' => [
                            ['nom' => 'Danané (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Danané', 'code_officiel' => 'SP-DNN'],
                            ['nom' => 'Danané', 'type' => 'commune', 'chef_lieu' => 'Danané', 'code_officiel' => 'CM-DNN'],
                        ],
                    ],
                    [
                        'nom' => 'Biankouma',
                        'type' => 'departement',
                        'chef_lieu' => 'Biankouma',
                        'code_officiel' => 'DP-BNK',
                        'enfants' => [
                            ['nom' => 'Biankouma (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Biankouma', 'code_officiel' => 'SP-BNK'],
                            ['nom' => 'Biankouma', 'type' => 'commune', 'chef_lieu' => 'Biankouma', 'code_officiel' => 'CM-BNK'],
                        ],
                    ],
                    [
                        'nom' => 'Zouan-Hounien',
                        'type' => 'departement',
                        'chef_lieu' => 'Zouan-Hounien',
                        'code_officiel' => 'DP-ZHN',
                        'enfants' => [
                            ['nom' => 'Zouan-Hounien (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Zouan-Hounien', 'code_officiel' => 'SP-ZHN'],
                            ['nom' => 'Zouan-Hounien', 'type' => 'commune', 'chef_lieu' => 'Zouan-Hounien', 'code_officiel' => 'CM-ZHN'],
                        ],
                    ],
                    [
                        'nom' => 'Sipilou',
                        'type' => 'departement',
                        'chef_lieu' => 'Sipilou',
                        'code_officiel' => 'DP-SPL',
                        'enfants' => [
                            ['nom' => 'Sipilou (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Sipilou', 'code_officiel' => 'SP-SPL'],
                            ['nom' => 'Sipilou', 'type' => 'commune', 'chef_lieu' => 'Sipilou', 'code_officiel' => 'CM-SPL'],
                        ],
                    ],
                ],
            ],
            [
                'nom' => 'Worodougou',
                'type' => 'region',
                'chef_lieu' => 'Séguéla',
                'code_officiel' => 'RG-WRD',
                'enfants' => [
                    [
                        'nom' => 'Séguéla',
                        'type' => 'departement',
                        'chef_lieu' => 'Séguéla',
                        'code_officiel' => 'DP-SGL2',
                        'enfants' => [
                            ['nom' => 'Séguéla (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Séguéla', 'code_officiel' => 'SP-SGL2'],
                            ['nom' => 'Massala', 'type' => 'sous_prefecture', 'chef_lieu' => 'Massala', 'code_officiel' => 'SP-MSL'],
                            ['nom' => 'Worofla', 'type' => 'sous_prefecture', 'chef_lieu' => 'Worofla', 'code_officiel' => 'SP-WRF'],
                            ['nom' => 'Djibrosso', 'type' => 'sous_prefecture', 'chef_lieu' => 'Djibrosso', 'code_officiel' => 'SP-JBR'],
                            ['nom' => 'Séguéla', 'type' => 'commune', 'chef_lieu' => 'Séguéla', 'code_officiel' => 'CM-SGL2'],
                            ['nom' => 'Worofla', 'type' => 'commune', 'chef_lieu' => 'Worofla', 'code_officiel' => 'CM-WRF'],
                        ],
                    ],
                    [
                        'nom' => 'Kani',
                        'type' => 'departement',
                        'chef_lieu' => 'Kani',
                        'code_officiel' => 'DP-KNI',
                        'enfants' => [
                            ['nom' => 'Kani (Sous-Préfecture)', 'type' => 'sous_prefecture', 'chef_lieu' => 'Kani', 'code_officiel' => 'SP-KNI'],
                            ['nom' => 'Kani', 'type' => 'commune', 'chef_lieu' => 'Kani', 'code_officiel' => 'CM-KNI'],
                        ],
                    ],
                ],
            ],
        ];

        // Insertion récursive de toute l'arborescence
        $this->insererArborescence($donnees);
    }

    private function insererArborescence(array $elements, ?int $parentId = null): void
    {
        foreach ($elements as $element) {
            $enfants = $element['enfants'] ?? [];
            unset($element['enfants']);

            $element['parent_id'] = $parentId;
            
            // Création de l'élément courant
            $circonscription = Circonscription::create($element);

            // S'il y a des enfants, on poursuit l'arborescence de manière récursive
            if (!empty($enfants)) {
                $this->insererArborescence($enfants, $circonscription->id);
            }
        }
    }
}