<?php

namespace App\Http\Controllers;

use App\Models\Market;
use App\Models\Project;
use App\Models\User;
use App\Models\Candidature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ProjectModule;
use Carbon\Carbon;

class MarketController extends Controller
{
    /**
     * Liste privée des marchés
     */
    public function index()
    {
        $markets = Market::with(['project', 'module'])->latest()->paginate(10);
        return view('profile.menus.passation.list', compact('markets'));
    }

    /**
     * Formulaire de CRÉATION d'un marché
     */
    public function create()
    {
        $projects = Project::select('id', 'code', 'nom')
            ->with(['modules' => function ($query) {
                $query->select('id', 'project_id', 'description', 'besoin_financier');
            }])
            ->orderBy('nom', 'asc')
            ->get()
            ->map(function ($proj) {
                return (object) [
                    'id'      => $proj->id,
                    'code'    => $proj->code ?? 'PRJ-' . $proj->id,
                    'nom'     => $proj->nom,
                    'title'   => $proj->nom, // Ajout de la propriété 'title'
                    'modules' => $proj->modules->map(function ($mod) {
                        return (object) [
                            'id'               => $mod->id,
                            'description'      => $mod->description,
                            'nom'              => $mod->description,
                            'title'            => $mod->description, // Ajout pour les modules si besoin
                            'besoin_financier' => $mod->besoin_financier ?? 0,
                        ];
                    }),
                ];
            });

        $prestataires = User::whereHas('role', function ($q) {
            $q->whereRaw('LOWER(name) = ?', ['prestataire']);
        })->select('id', 'name')->orderBy('name', 'asc')->get();

        $marche = new Market();

        return view('profile.menus.marche-form', compact('projects', 'prestataires', 'marche'));
    }
    /**
     * Formulaire d'ÉDITION du CYCLE DE VIE
     */
    public function editEtape(Market $marche)
    {
        return view('profile.menus.passation.form', compact('marche'));
    }

    /**
     * Mise à jour du CYCLE DE VIE
     */
    public function updateEtape(Request $request, Market $marche)
    {
        $validated = $request->validate([
            'etape'                 => 'required|string',
            'methode_passation'     => 'nullable|string|in:AON,AOI,AOR,COTA',
            'date_changement'       => 'required|date',
            'document_justificatif' => 'nullable|file|mimes:pdf|max:5120',
            'commentaire'           => 'required|string',
        ]);

        if ($request->hasFile('document_justificatif')) {
            $request->file('document_justificatif')->store('justificatifs_marches', 'public');
        }

        $dataToUpdate = [
            'etape' => $validated['etape'],
        ];

        if (!empty($validated['methode_passation'])) {
            $dataToUpdate['methode_passation'] = $validated['methode_passation'];
        }

        $marche->update($dataToUpdate);

        return redirect()->route('passation.index')
            ->with('success', 'L\'étape du marché a été mise à jour avec succès !');
    }

    /**
     * Enregistrement d'un nouveau marché en BDD
     */
    public function store(Request $request)
{
    // 1. Harmonisation des nommages provenant du formulaire Blade / Alpine.js
    $request->merge([
        'numero_reference'       => $request->input('numero_reference', $request->input('reference')),
        'project_module_id'      => $request->input('project_module_id', $request->input('module_id')),
        'besoin_financier'       => $request->input('besoin_financier', $request->input('montant_previsionnel')),
        'candidature_start_date' => $request->input('candidature_start_date', $request->input('date_debut')),
        'candidature_end_date'   => $request->input('candidature_end_date', $request->input('date_fin')),
        'user_id'                => $request->input('user_id', $request->input('prestataire_id')),
        'status'                 => $request->input('status', $request->input('statut', 'Non attribué')),
        'etape'                  => $request->input('etape', $request->input('etape_actuelle', 'EXPRESSION_BESOIN')),
    ]);

    // 2. Décodage de la chaîne JSON (specifications ou besoins_materiels)
    $specificationsInput = $request->input('specifications', $request->input('besoins_materiels'));
    if (is_string($specificationsInput)) {
        $decoded = json_decode($specificationsInput, true);
        $request->merge([
            'besoins_materiels' => is_array($decoded) ? $decoded : [],
        ]);
    }

    // 3. Récupération des modèles associés pour les validations personnalisées
    $project = Project::find($request->input('project_id'));
    $module  = ProjectModule::find($request->input('project_module_id'));

    // 4. Validation stricte des données
    $validated = $request->validate([
        'numero_reference'  => 'nullable|string|max:255',
        'project_id'        => 'required|exists:projects,id',
        'project_module_id' => 'nullable|exists:project_modules,id',
        'objet'             => 'required|string|max:255',
        'methode_passation' => 'nullable|string',

        // Validation du budget disponible sur le module
        'besoin_financier'  => [
            'required',
            'numeric',
            'min:0',
            function ($attribute, $value, $fail) use ($module) {
                if ($module) {
                    $cumulExistant = $module->markets()->sum('besoin_financier');
                    $budgetModule  = $module->besoin_financier ?? $module->budget ?? 0;
                    $nouveauTotal  = $cumulExistant + $value;

                    if ($budgetModule > 0 && $nouveauTotal > $budgetModule) {
                        $reste  = max(0, $budgetModule - $cumulExistant);
                        $devise = $module->devise ?? 'USD';
                        $fail("Le montant dépasse le budget alloué à cette composante. Budget disponible : " . number_format($reste, 2, ',', ' ') . " {$devise}.");
                    }
                }
            },
        ],

        // Validation du tableau de la proposition technique
        'besoins_materiels'                 => 'required|array|min:1',
        'besoins_materiels.*.designation'   => 'required|string',
        'besoins_materiels.*.quantite'      => 'required|string', // Format texte pour accepter "12 sessions", "1 prestation", etc.
        'besoins_materiels.*.specification' => 'nullable|string',

        // Validation des dates par rapport aux contraintes du projet
        'candidature_start_date' => [
            'nullable',
            'date',
            function ($attribute, $value, $fail) use ($project) {
                if ($project && $project->date_debut && Carbon::parse($value)->lt(Carbon::parse($project->date_debut))) {
                    $dateMin = Carbon::parse($project->date_debut)->format('d/m/Y');
                    $fail("La date de début du marché ne peut pas être antérieure au début du projet ({$dateMin}).");
                }
            },
        ],

        'candidature_end_date' => [
            'nullable',
            'date',
            'after_or_equal:candidature_start_date',
            function ($attribute, $value, $fail) use ($project) {
                if ($project && $project->date_fin && Carbon::parse($value)->gt(Carbon::parse($project->date_fin))) {
                    $dateMax = Carbon::parse($project->date_fin)->format('d/m/Y');
                    $fail("La date de fin du marché ({$value}) dépasse la date de fin prévue du projet ({$dateMax}).");
                }
            },
        ],

        'user_id' => 'nullable|exists:users,id',
        'status'  => 'nullable|string',
        'etape'   => 'nullable|string',
    ]);

    // 5. Enregistrement en BDD en utilisant uniquement la variable $validated
    Market::create([
        'numero_reference'       => $validated['numero_reference'] ?? null,
        'project_id'             => $validated['project_id'],
        'project_module_id'      => $validated['project_module_id'] ?? null,
        'objet'                  => $validated['objet'],
        'methode_passation'      => $validated['methode_passation'] ?? null,
        'besoin_financier'       => $validated['besoin_financier'],
        'besoins_materiels'      => $validated['besoins_materiels'], // Casté automatiquement via $casts = ['besoins_materiels' => 'array'] sur le Modèle
        'devise'                 => $project->budget_devise ?? $project->devise ?? $request->input('devise', 'USD'),
        'candidature_start_date' => $validated['candidature_start_date'] ?? null,
        'candidature_end_date'   => $validated['candidature_end_date'] ?? null,
        'user_id'                => $validated['user_id'] ?? null,
        'status'                 => $validated['status'] ?? 'Non attribué',
        'etape'                  => $validated['etape'] ?? 'EXPRESSION_BESOIN',
        'created_by'             => Auth::id(),
    ]);

    return redirect()->route('passation.index')
        ->with('success', 'Le marché et sa proposition technique ont été enregistrés avec succès !');
}

    /**
     * Affiche la liste publique des marchés / opportunités.
     */
    public function indexPublique()
    {
        $markets = Market::with(['project', 'module'])->latest()->get();

        return view('pages.marche.liste', compact('markets'));
    }

    /**
     * Affiche les détails d'un marché spécifique en accès public.
     */
    public function showPublique($id)
    {
        $marche = Market::with(['project', 'module'])->findOrFail($id);

        return view('pages.candidature-form', compact('marche'));
    }

    /**
     * Traite la postulation à un marché spécifique (Évaluation automatique)
     */
    public function postuler(Request $request, $id)
    {
        $marche = Market::findOrFail($id);

        $validated = $request->validate([
            'nom_candidat'                          => 'required|string|max:255',
            'numero_registre_commerce'              => 'required|string|max:100',

            // Documents administratifs
            'file_rccm'                             => 'required|file|mimes:pdf|max:10240',
            'file_acte_constitution'                => 'nullable|file|mimes:pdf|max:10240',
            'file_dfe'                              => 'required|file|mimes:pdf|max:10240',
            'file_arf'                              => 'required|file|mimes:pdf|max:10240',
            'file_cnps'                             => 'required|file|mimes:pdf|max:10240',
            'file_attestation_bancaire'             => 'required|file|mimes:pdf|max:10240',

            // Offres financière & technique
            'proposition_financiere'                => 'required|numeric|min:0',
            'propositions_techniques'               => 'nullable|array',
            'propositions_techniques.*.designation' => 'nullable|string',
            'propositions_techniques.*.quantite'    => 'nullable|numeric|min:0',
        ]);

        // Stockage des Fichiers PDF
        $pathRccm     = $request->file('file_rccm')->store('candidatures/rccm', 'public');
        $pathDfe      = $request->file('file_dfe')->store('candidatures/dfe', 'public');
        $pathArf      = $request->file('file_arf')->store('candidatures/arf', 'public');
        $pathCnps     = $request->file('file_cnps')->store('candidatures/cnps', 'public');
        $pathBancaire = $request->file('file_attestation_bancaire')->store('candidatures/attestations_bancaires', 'public');

        $pathActeConstitution = $request->hasFile('file_acte_constitution')
            ? $request->file('file_acte_constitution')->store('candidatures/actes_constitution', 'public')
            : null;

        // ÉVALUATION AUTOMATIQUE
        $estAccepte = true;
        $motifsRefus = [];

        // 1. Évaluation Financière
        $budgetMax = $marche->besoin_financier ?? $marche->montant_max ?? null;

        if ($budgetMax !== null && $validated['proposition_financiere'] > $budgetMax) {
            $estAccepte = false;
            $motifsRefus[] = "La proposition financière (" . number_format($validated['proposition_financiere'], 0, ',', ' ') . " FCFA) dépasse le budget maximal autorisé de " . number_format($budgetMax, 0, ',', ' ') . " FCFA.";
        }

        // 2. Évaluation Technique
        $besoinsRequis = is_string($marche->besoins_materiels)
            ? json_decode($marche->besoins_materiels, true)
            : $marche->besoins_materiels;

        $propositionsSaisies = $validated['propositions_techniques'] ?? [];

        if (is_array($besoinsRequis)) {
            foreach ($besoinsRequis as $index => $item) {
                $designation = $item['designation'] ?? $item['nom'] ?? "Article #" . ($index + 1);
                $qteRequise  = (int) ($item['quantite'] ?? 1);

                $qteProposee = 0;
                foreach ($propositionsSaisies as $prop) {
                    if (isset($prop['designation']) && $prop['designation'] === $designation) {
                        $qteProposee = (int) ($prop['quantite'] ?? 0);
                        break;
                    }
                }

                if ($qteProposee < $qteRequise) {
                    $estAccepte = false;
                    $motifsRefus[] = "Quantité insuffisante pour '{$designation}' : {$qteProposee} proposée(s) vs {$qteRequise} requise(s).";
                }
            }
        }

        $status = $estAccepte ? 'Accepté' : 'Rejeté';
        $motifStatut = $estAccepte
            ? 'Candidature conforme aux exigences financières et techniques du cahier des charges.'
            : implode(' | ', $motifsRefus);

        // Enregistrement de la candidature
        Candidature::create([
            'marche_id'                 => $marche->id,
            'nom_candidat'              => $validated['nom_candidat'],
            'numero_registre_commerce'  => $validated['numero_registre_commerce'],
            'file_rccm'                 => $pathRccm,
            'file_acte_constitution'    => $pathActeConstitution,
            'file_dfe'                  => $pathDfe,
            'file_arf'                  => $pathArf,
            'file_cnps'                 => $pathCnps,
            'file_attestation_bancaire' => $pathBancaire,
            'proposition_financiere'    => $validated['proposition_financiere'],
            'proposition_technique'     => json_encode($propositionsSaisies),
            'status'                    => $status,
            'motif_statut'              => $motifStatut,
        ]);

        if ($estAccepte) {
            return back()->with('success', 'Votre candidature et vos documents ont été validés et retenus avec succès !');
        } else {
            return back()->with('warning', 'Votre candidature a été enregistrée mais non retenue : ' . $motifStatut);
        }
    }
}
