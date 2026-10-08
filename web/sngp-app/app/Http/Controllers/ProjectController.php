<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Paiement;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use App\Models\Market;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\ProjectCodeGenerator;

class ProjectController extends Controller
{
    /**
     * Affiche la liste des projets selon le rôle
     */
    public function index()
    {
        $user = Auth::user();
        $roleName = $user->role->name;

        // Si c'est l'UGP, il ne voit STRICTEMENT que ses projets créés
        if ($roleName === 'ugp') {
            $projects = Project::where('user_id', $user->id)->with('modules')->get();
        } else {
            // Les autres rôles (Admin, Ministre, Ordonnateur) voient TOUT
            $projects = Project::with(['user', 'modules'])->get();
        }

        return view('profile.menus.projects.list', compact('projects', 'roleName'));
    }

    /**
     * Affichage de la console d'arbitrage budgétaire réel avec Taux de change API
     */
    public function budget()
    {
        // 1. Récupérer le taux USD -> XOF avec mise en cache de 6 heures
        $usdToXof = Cache::remember('usd_to_xof_rate', now()->addHours(6), function () {
            try {
                $apiKey = env('EXCHANGERATE_API_KEY');
                $response = Http::withoutVerifying()->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['conversion_rates']['XOF'] ?? 605.20;
                }
            } catch (\Exception $e) {
                return 605.20;
            }
            return 605.20;
        });

        // 2. Charger les projets avec leurs paiements pour éviter le problème de requêtes N+1
        $projects = Project::with(['paiements'])->orderBy('code', 'asc')->get();

        // 3. Récupérer l'historique des réallocations de manière sécurisée
        $revisions = collect();
        if (Schema::hasTable('budget_revisions')) {
            // Si ton modèle BudgetRevision existe, tu pourras décommenter la ligne ci-dessous :
            // $revisions = \App\Models\BudgetRevision::with(['sourceProject', 'targetProject'])->latest()->get();
            $revisions = DB::table('budget_revisions')->get();
        }

        // 4. Passer toutes les variables indispensables à la vue unique
        return view('profile.menus.budget', compact('projects', 'revisions', 'usdToXof'));
    }

    /**
     * Affiche le formulaire de modification d'étape pour un marché spécifique
     */
    public function editEtape($id)
    {
        $user = Auth::user();
        $roleName = $user->role->name;

        $marche = Market::with('project')->findOrFail($id);

        if ($roleName === 'ugp' && $marche->project->user_id !== $user->id) {
            abort(403, "Action non autorisée.");
        }

        return view('profile.menus.passation.form', compact('marche', 'roleName'));
    }

    /**
     * Traite la mise à jour réelle de l'étape en base de données
     */
    public function updateEtape(Request $request, $id)
    {
        $request->validate([
            'etape' => 'required|string',
            'date_changement' => 'required|date',
            'commentaire' => 'required|string|min:10',
            'document_justificatif' => 'nullable|file|mimes:pdf|max:4096', // Max 4Mo
        ]);

        $marche = Market::findOrFail($id);

        if ($request->hasFile('document_justificatif')) {
            $path = $request->file('document_justificatif')->store('justificatifs_passation', 'public');
        }

        $marche->etape = $request->input('etape');
        $marche->save();

        return redirect()->route('passation.index')->with('success', "L'étape du dossier {$marche->numero_reference} a été mise à jour avec succès.");
    }

    /**
     * Affiche l'espace de suivi des finances.
     */
    public function finances()
    {
        return view('profile.menus.finances');
    }

    /**
     * Console de la Comptabilité Financière & Engagements (Données Réelles)
     */
    public function comptabiliteFinanciere()
    {
        $projects = Project::with(['paiements'])->orderBy('code', 'asc')->get();

        $dotationTotale = 0;
        $totalEngage = 0;
        $totalPaye = 0;

        $situationFinanciere = $projects->map(function ($project) use (&$dotationTotale, &$totalEngage, &$totalPaye) {
            $dotation = $project->budget_value;
            $engage = $project->paiements->whereIn('status', ['valide', 'engage', 'paye', 'effectue'])->sum('montant');
            $paye = $project->paiements->whereIn('status', ['paye', 'effectue'])->sum('montant');

            $dotationTotale += $dotation;
            $totalEngage += $engage;
            $totalPaye += $paye;

            $tauxEngagement = $dotation > 0 ? ($engage / $dotation) * 100 : 0;
            $tauxAbsorption = $dotation > 0 ? ($paye / $dotation) * 100 : 0;

            return [
                'code'            => $project->code,
                'nom'             => $project->nom,
                'dotation'        => $dotation,
                'engage'          => $engage,
                'paye'            => $paye,
                'taux_engagement' => $tauxEngagement,
                'taux_absorption' => $tauxAbsorption,
            ];
        });

        $tauxEngagementGlobal = $dotationTotale > 0 ? ($totalEngage / $dotationTotale) * 100 : 0;
        $tauxDecaissementGlobal = $dotationTotale > 0 ? ($totalPaye / $dotationTotale) * 100 : 0;

        return view('profile.menus.comptabilite.comptabilite_financiere', compact(
            'dotationTotale',
            'totalEngage',
            'totalPaye',
            'tauxEngagementGlobal',
            'tauxDecaissementGlobal',
            'situationFinanciere'
        ));
    }

    /**
     * Console de Contrôle de Gestion et Performance Opérationnelle
     */
    public function comptabiliteGestion()
    {
        $projects = Project::with(['paiements'])->orderBy('code', 'asc')->get();

        $nombreProjets = $projects->count();
        $totalBudgetGlobal = $projects->sum('budget_value');
        $totalDecaisse = Paiement::whereIn('status', ['paye', 'effectue'])->sum('montant');

        $coutMoyenProjet = $nombreProjets > 0 ? ($totalDecaisse / $nombreProjets) : 0;
        $ratioTerrain = $totalBudgetGlobal > 0 ? ($totalDecaisse / $totalBudgetGlobal) * 100 : 0;

        $coutFonctionnement = $projects->filter(function ($project) {
            return str_contains(strtolower($project->code), 'fonc') ||
                str_contains(strtolower($project->nom), 'fonctionnement') ||
                str_contains(strtolower($project->nom), 'logistique');
        })->map(function ($project) {
            return $project->paiements->whereIn('status', ['paye', 'effectue'])->sum('montant');
        })->sum();

        $totalAvenants = Schema::hasColumn('projects', 'avenants_value')
            ? $projects->sum('avenants_value')
            : 0;

        $analysesGestion = $projects->map(function ($project) {
            $budgetAlloue = $project->budget_value;
            $consommationReelle = $project->paiements->whereIn('status', ['paye', 'effectue'])->sum('montant');

            $ratioPerformance = $budgetAlloue > 0 ? ($consommationReelle / $budgetAlloue) * 100 : 0;

            $statusGestion = 'Optimale';
            if ($ratioPerformance > 90) {
                $statusGestion = 'Alerte Surconsommation';
            } elseif ($ratioPerformance < 30 && $consommationReelle > 0) {
                $statusGestion = 'Sous-exécution Opérationnelle';
            } elseif ($consommationReelle == 0) {
                $statusGestion = 'En Attente de Démarrage';
            }

            return [
                'code'              => $project->code,
                'nom'               => $project->nom,
                'budget'            => $budgetAlloue,
                'consommation'      => $consommationReelle,
                'ratio_performance' => $ratioPerformance,
                'status_gestion'    => $statusGestion,
            ];
        });

        return view('profile.menus.comptabilite.comptabilite_gestion', compact(
            'nombreProjets',
            'totalDecaisse',
            'coutMoyenProjet',
            'ratioTerrain',
            'coutFonctionnement',
            'totalAvenants',
            'analysesGestion'
        ));
    }

    public function comptabiliteActif()
    {
        $projects = Project::with(['modules.market.paiements', 'paiements'])->orderBy('code', 'asc')->get();
        $totalAllocated = $projects->sum('budget_value');

        $totalDisbursed = 0;
        foreach ($projects as $project) {
            $totalDisbursed += $project->paiements()->where('status', 'Effectué')->sum('montant');
        }

        return view('profile.menus.comptabilite.comptabilite_actif', compact(
            'projects',
            'totalAllocated',
            'totalDisbursed'
        ));
    }

    public function comptabiliteCaisse()
    {
        $fluxCaisse = Paiement::with(['project', 'market'])
            ->where('status', 'Effectué')
            ->orderBy('date_paiement', 'desc')
            ->get();

        $dotationInitialeBAD  = Project::where('devise', '!=', 'XOF')->sum('budget_value');
        $dotationInitialeEtat = Project::where('devise', 'XOF')->sum('budget_value');

        $decaissesBAD = $fluxCaisse->filter(function ($p) {
            return ($p->devise ?? 'XOF') !== 'XOF' || str_contains(strtolower($p->etape_administrative ?? ''), 'bad');
        })->sum('montant');

        $decaissesEtat = $fluxCaisse->filter(function ($p) {
            return ($p->devise ?? 'XOF') === 'XOF' && !str_contains(strtolower($p->etape_administrative ?? ''), 'bad');
        })->sum('montant');

        $totalDecaisse = $decaissesBAD + $decaissesEtat;

        $soldeBAD  = $dotationInitialeBAD - $decaissesBAD;
        $soldeEtat = $dotationInitialeEtat - $decaissesEtat;
        $soldeGlobal = $soldeBAD + $soldeEtat;

        return view('profile.menus.comptabilite.comptabilite_caisse', compact(
            'fluxCaisse',
            'soldeGlobal',
            'soldeBAD',
            'soldeEtat',
            'totalDecaisse'
        ));
    }

    public function comptabiliteMonetaire()
    {
        // 1. Récupération du taux USD -> XOF via le cache (identique à la page budget)
        $usdToXof = Cache::remember('usd_to_xof_rate', now()->addHours(6), function () {
            try {
                $apiKey = env('EXCHANGERATE_API_KEY');
                $response = Http::withoutVerifying()->get("https://v6.exchangerate-api.com/v6/{$apiKey}/latest/USD");

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['conversion_rates']['XOF'] ?? 605.20;
                }
            } catch (\Exception $e) {
                return 605.20;
            }
            return 605.20;
        });

        // 2. Récupération des projets et calcul des enveloppes réelles globales
        $projets = Project::all();
        $enveloppeGlobale = $projets->sum('budget_value');

        // Correction : Utilisation de budget_devise au lieu de devise
        $enveloppeBAD  = $projets->where('budget_devise', '!=', 'XOF')->sum('budget_value');
        $enveloppeEtat = $projets->where('budget_devise', 'XOF')->sum('budget_value');

        // 3. Récupération de tous les flux de décaissements réels validés
        $decaissements = Paiement::with(['project', 'market'])->where('status', 'Effectué')->get();
        $totalDecaisse = $decaissements->sum('montant');

        // Ventilation réelle des décaissements
        $decaisseBAD = $decaissements->filter(function ($p) {
            return ($p->devise ?? 'XOF') !== 'XOF' || str_contains(strtolower($p->etape_administrative ?? ''), 'bad');
        })->sum('montant');

        $decaisseEtat = $decaissements->filter(function ($p) {
            return ($p->devise ?? 'XOF') === 'XOF' && !str_contains(strtolower($p->etape_administrative ?? ''), 'bad');
        })->sum('montant');

        // 4. Calcul des gains et pertes de change réels
        $totalGainsChange  = $decaissements->sum('gain_change' ?? 0);
        $totalPertesChange = $decaissements->sum('perte_change' ?? 0);

        // 5. Calcul des soldes monétaires réels et des taux d'exécution financiers
        $soldeGlobal = $enveloppeGlobale - $totalDecaisse;
        $soldeBAD    = $enveloppeBAD - $decaisseBAD;
        $soldeEtat   = $enveloppeEtat - $decaisseEtat;

        // Calcul des taux réels
        $tauxExecutionGlobal = $enveloppeGlobale > 0 ? round(($totalDecaisse / $enveloppeGlobale) * 100, 2) : 0;
        $tauxExecutionBAD    = $enveloppeBAD > 0 ? round(($decaisseBAD / $enveloppeBAD) * 100, 2) : 0;
        $tauxExecutionEtat   = $enveloppeEtat > 0 ? round(($decaisseEtat / $enveloppeEtat) * 100, 2) : 0;

        // 6. Envoi de TOUTES les variables, incluant désormais 'usdToXof'
        return view('profile.menus.comptabilite.comptabilite_monetaire', compact(
            'projets',
            'enveloppeGlobale',
            'enveloppeBAD',
            'enveloppeEtat',
            'totalDecaisse',
            'decaisseBAD',
            'decaisseEtat',
            'soldeGlobal',
            'soldeBAD',
            'soldeEtat',
            'tauxExecutionGlobal',
            'tauxExecutionBAD',
            'tauxExecutionEtat',
            'totalGainsChange',
            'totalPertesChange',
            'decaissements',
            'usdToXof'
        ));
    }

    /**
     * Affiche la console de suivi des paiements.
     */
    public function paiements()
    {
        $totalPaiements = 0;
        return view('profile.menus.paiements', compact('totalPaiements'));
    }

    /**
     * Afficher le Plan de Passation des Marchés.
     */
    public function passation()
    {
        return view('profile.menus.passation');
    }

    public function dashboard()
    {
        // On ajoute 'modules.markets' dans le with()
        $projects = Project::with(['modules.markets'])->get();

        return view('profile.menus.projects.list', compact('projects'));
    }

    /**
     * Formulaire d'ajout -> form.blade.php
     */
    public function create()
    {
        // On passe une instance vide pour que Blade et Alpine.js lisent des valeurs neutres
        $project = new Project();
        return view('profile.menus.projects.form', compact('project'));
    }

    /**
     * Redirection ou nettoyage de passationCreate dans ProjectController
     */
    public function passationCreate()
    {
        // Pour éviter toute confusion de route et tout crash 504 :
        return app(MarketController::class)->create();
    }

    public function passationIndex()
    {
        $user = Auth::user();
        $roleName = $user->role->name;

        if ($roleName === 'ugp') {
            // Filtrage direct et performant grâce à la colonne project_id
            $marches = Market::whereHas('project', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['project', 'module'])->get();
        } else {
            // Chargement global pour les autres rôles
            $marches = Market::with(['project', 'module'])->get();
        }

        return view('profile.menus.passation.list', compact('marches', 'roleName'));
    }

    public function edit($id)
    {
        // On récupère le projet avec ses composantes (modules)
        $project = Project::with('modules')->findOrFail($id);

        // On charge le fichier form.blade.php en lui injectant le projet
        return view('profile.menus.projects.form', compact('project'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom'                  => 'required|string|max:255',
            'secteur_activite'     => 'required|string',
            'categorie'            => 'required|string',
            'region'               => 'required|string|max:100',
            'departement'          => 'nullable|string|max:100',
            'commune'              => 'required|string|max:100',
            'ville'                => 'nullable|string|max:100',
            'zones_couvertes'      => 'nullable|array',
            'budget_initial'       => 'required|numeric|min:0',
            'budget_devise'        => 'required|string|max:10',
            'taux_change'          => 'nullable|numeric|min:0',
            'pourcentage_bailleur' => 'nullable|numeric|min:0|max:100',
            'pourcentage_etat'     => 'nullable|numeric|min:0|max:100',
            'financement_bailleur' => 'nullable|numeric|min:0',
            'financement_etat'     => 'nullable|numeric|min:0',
            'description'          => 'nullable|string',
            'start_date'           => 'nullable|date',
            'end_date'             => 'nullable|date|after_or_equal:start_date',
            'modules'              => 'nullable|array',
            'modules.*.number'     => 'required',
            'modules.*.description' => 'required|string',
            'modules.*.besoin_financier' => 'required|numeric',
            'modules.*.duree'      => 'required',
        ]);

        $project = Project::findOrFail($id);
        $taux = $request->input('taux_change', 1.0);

        $project->update([
            'nom'                  => $validated['nom'],
            'description'          => $request->input('description'),
            'secteur_activite'     => $validated['secteur_activite'],
            'categorie'            => $validated['categorie'],
            'region'               => $validated['region'],
            'departement'          => $request->input('departement'),
            'commune'              => $validated['commune'],
            'ville'                => $request->input('ville'),
            'zones_couvertes'      => $request->input('zones_couvertes', []),
            'budget_initial'       => $validated['budget_initial'],
            'budget_devise'        => $validated['budget_devise'],
            'taux_change'          => $taux,
            'budget_value'         => $validated['budget_initial'] * $taux,
            'pourcentage_bailleur' => $request->input('pourcentage_bailleur'),
            'pourcentage_etat'     => $request->input('pourcentage_etat'),
            'financement_bailleur' => $request->input('financement_bailleur'),
            'financement_etat'     => $request->input('financement_etat'),
            'start_date'           => $request->input('start_date'),
            'end_date'             => $request->input('end_date'),
        ]);

        if ($request->has('modules')) {
            $project->modules()->delete();
            foreach ($request->modules as $moduleData) {
                $project->modules()->create([
                    'number'           => $moduleData['number'],
                    'description'      => $moduleData['description'],
                    'besoin_financier' => $moduleData['besoin_financier'],
                    'devise'           => $validated['budget_devise'],
                    'duree'            => $moduleData['duree'],
                ]);
            }
        }

        return redirect()->route('profile.menus.projects.list')
            ->with('success', 'Le projet a été mis à jour avec succès.');
    }

    /**
     * Enregistre un projet, génère automatiquement son code et enregistre ses modules.
     */
    public function store(Request $request)
    {
        // 1. Validation : le code devient optionnel à la saisie, mais s'il est renseigné il doit être unique
        $validated = $request->validate([
            'code'                 => 'nullable|string|max:100|unique:projects,code',
            'nom'                  => 'required|string|max:255',
            'description'          => 'nullable|string',
            'secteur_activite'     => 'required|string',
            'categorie'            => 'required|string',
            'region'               => 'required|string|max:100',
            'departement'          => 'nullable|string|max:100',
            'commune'              => 'required|string|max:100',
            'ville'                => 'nullable|string|max:100',
            'zones_couvertes'      => 'nullable|array',
            'budget_initial'       => 'required|numeric|min:0',
            'budget_devise'        => 'required|string|max:10',
            'budget_value'         => 'nullable|numeric',
            'taux_change'          => 'nullable|numeric',
            'financement_bailleur' => 'nullable|numeric',
            'financement_etat'     => 'nullable|numeric',
            'start_date'           => 'nullable|date',
            'end_date'             => 'nullable|date',
            'modules'              => 'nullable|array',
            'modules.*.number'     => 'required',
            'modules.*.description' => 'required|string',
            'modules.*.besoin_financier' => 'required|numeric',
            'modules.*.duree'      => 'required',
        ]);

        try {
            DB::beginTransaction();

            // 2. Détermination du Code Projet (Manuel vs Généré automatiquement)
            $codeProjet = $request->filled('code')
                ? trim($request->input('code'))
                : ProjectCodeGenerator::generate([
                    'region'           => $validated['region'],
                    'commune'          => $validated['commune'],
                    'ville'            => $request->input('ville'),
                    'secteur_activite' => $validated['secteur_activite'],
                    'categorie'        => $validated['categorie'],
                ]);

            // 3. Assemblage des données du projet
            $projectData = [
                'code'                 => $codeProjet,
                'nom'                  => $validated['nom'],
                'description'          => $request->input('description'),
                'secteur_activite'     => $validated['secteur_activite'],
                'categorie'            => $validated['categorie'],
                'region'               => $validated['region'],
                'departement'          => $request->input('departement'),
                'commune'              => $validated['commune'],
                'ville'                => $request->input('ville'),
                'zones_couvertes'      => $request->input('zones_couvertes', []),
                'budget_initial'       => $validated['budget_initial'],
                'budget_devise'        => $validated['budget_devise'],
                'budget_value'         => $request->input('budget_value', 0),
                'taux_change'          => $request->input('taux_change', 1.0),
                'financement_bailleur' => $request->input('financement_bailleur', 0),
                'financement_etat'     => $request->input('financement_etat', 0),
                'start_date'           => $request->input('start_date'),
                'end_date'             => $request->input('end_date'),
                'status'               => 'brouillon',
                'user_id'              => Auth::id() ?? 1,
            ];

            $project = Project::create($projectData);

            // 4. Création des modules
            if ($request->filled('modules')) {
                foreach ($request->modules as $moduleData) {
                    $project->modules()->create([
                        'number'           => $moduleData['number'],
                        'description'      => $moduleData['description'],
                        'besoin_financier' => $moduleData['besoin_financier'],
                        'devise'           => $validated['budget_devise'],
                        'duree'            => $moduleData['duree'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('profile.menus.projects.list')
                ->with('success', "Le projet {$project->nom} a été créé avec succès (Code : {$project->code}).");
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Erreur lors de la création du projet : " . $e->getMessage());

            return back()->withInput()->with('error', 'Erreur lors de l\'enregistrement : ' . $e->getMessage());
        }
    }

    /**
     * Accesseur : Calcule le budget en FCFA selon la devise et le taux du projet
     */
    public function getBudgetInFcfaAttribute(): float
    {
        $devise = strtoupper($this->attributes['budget_devise'] ?? 'XOF');
        $initial = (float) ($this->attributes['budget_initial'] ?? 0);
        $value = (float) ($this->attributes['budget_value'] ?? 0);
        $taux = (float) ($this->attributes['taux_change'] ?? 1);

        // Si déjà en FCFA/XOF
        if (in_array($devise, ['FCFA', 'XOF'])) {
            return $initial;
        }

        // Si la valeur convertie en FCFA est déjà stockée dans budget_value
        if ($value > 0) {
            return $value;
        }

        // Conversion selon le taux enregistré
        return $initial * $taux;
    }
}
