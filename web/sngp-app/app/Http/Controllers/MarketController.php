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
use App\Mail\NotificationStatutCandidature;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationAttributionMarche;

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
                    'title'   => $proj->nom,
                    'modules' => $proj->modules->map(function ($mod) {
                        return (object) [
                            'id'               => $mod->id,
                            'description'      => $mod->description,
                            'nom'              => $mod->description,
                            'title'            => $mod->description,
                            'besoin_financier' => $mod->besoin_financier ?? 0,
                        ];
                    }),
                ];
            });

        $prestataires = User::whereHas('role', function ($q) {
            $q->whereRaw('LOWER(name) = ?', ['prestataire']);
        })->select('id', 'name')->orderBy('name', 'asc')->get();

        // Récupération des utilisateurs habilités pour la COJO (Membres, Présidents, Secrétaires)
        $cojoUsers = User::whereHas('role', function ($q) {
            $q->whereIn('name', ['cojo_depouillement', 'cojo_analyse', 'cojo']);
        })->select('id', 'name', 'email')->orderBy('name', 'asc')->get();

        $marche = new Market();

        return view('profile.menus.marche-form', compact('projects', 'prestataires', 'marche', 'cojoUsers'));
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
        // 1. Harmonisation des nommages provenant du formulaire
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

        // 2. Décodage de la chaîne JSON (besoins_materiels / specifications)
        $specificationsInput = $request->input('specifications', $request->input('besoins_materiels'));
        if (is_string($specificationsInput)) {
            $decoded = json_decode($specificationsInput, true);
            $request->merge([
                'besoins_materiels' => is_array($decoded) ? $decoded : [],
            ]);
        }

        // 3. Récupération des modèles associés
        $project = Project::find($request->input('project_id'));
        $module  = ProjectModule::find($request->input('project_module_id'));

        // 4. Validation stricte incluant COJO et ANRMPCI
        $validated = $request->validate([
            'numero_reference'                  => 'nullable|string|max:255',
            'project_id'                        => 'required|exists:projects,id',
            'project_module_id'                 => 'nullable|exists:project_modules,id',
            'objet'                             => 'required|string|max:255',
            'methode_passation'                 => 'nullable|string',
            
            // Validation COJO (Sous-comités stockés en JSON)
            'comite_depouillement'              => 'nullable|array',
            'comite_analyse'                    => 'nullable|array',

            // Jalons d'attribution et recours ANRMPCI
            'date_attribution_provisoire'       => 'nullable|date',
            'fin_periode_contestation'          => 'nullable|date|after_or_equal:date_attribution_provisoire',
            'date_attribution_definitive'       => 'nullable|date',
            'sous_recours_anrmp'                => 'boolean',
            'statut_recours_anrmp'              => 'nullable|string',
            'motif_recours_anrmp'               => 'nullable|string',
            'date_attestation_bonne_execution'  => 'nullable|date',

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

            'besoins_materiels'                 => 'required|array|min:1',
            'besoins_materiels.*.designation'   => 'required|string',
            'besoins_materiels.*.quantite'      => 'required|string',
            'besoins_materiels.*.specification' => 'nullable|string',

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

        // 5. Enregistrement en BDD
        Market::create([
            'numero_reference'                  => $validated['numero_reference'] ?? null,
            'project_id'                        => $validated['project_id'],
            'project_module_id'                 => $validated['project_module_id'] ?? null,
            'objet'                             => $validated['objet'],
            'methode_passation'                 => $validated['methode_passation'] ?? null,
            'comite_depouillement'              => $validated['comite_depouillement'] ?? null,
            'comite_analyse'                    => $validated['comite_analyse'] ?? null,
            'besoin_financier'                  => $validated['besoin_financier'],
            'besoins_materiels'                 => $validated['besoins_materiels'],
            'devise'                            => $project->budget_devise ?? $project->devise ?? $request->input('devise', 'USD'),
            'candidature_start_date'            => $validated['candidature_start_date'] ?? null,
            'candidature_end_date'              => $validated['candidature_end_date'] ?? null,
            'date_attribution_provisoire'       => $validated['date_attribution_provisoire'] ?? null,
            'fin_periode_contestation'          => $validated['fin_periode_contestation'] ?? null,
            'date_attribution_definitive'       => $validated['date_attribution_definitive'] ?? null,
            'sous_recours_anrmp'                => $validated['sous_recours_anrmp'] ?? false,
            'statut_recours_anrmp'              => $validated['statut_recours_anrmp'] ?? null,
            'motif_recours_anrmp'               => $validated['motif_recours_anrmp'] ?? null,
            'date_attestation_bonne_execution'  => $validated['date_attestation_bonne_execution'] ?? null,
            'user_id'                           => $validated['user_id'] ?? null,
            'status'                            => $validated['status'] ?? 'Non attribué',
            'etape'                             => $validated['etape'] ?? 'EXPRESSION_BESOIN',
            'created_by'                        => Auth::id(),
        ]);

        return redirect()->route('passation.index')
            ->with('success', 'Le marché, la configuration COJO et les jalons ont été enregistrés avec succès !');
    }

    /**
     * Affiche la liste publique des marchés / opportunités.
     */
    public function indexPublique()
    {
        $markets = Market::with(['project', 'module'])->latest()->paginate(10);
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

    // Postuler à un marché spécifique
    public function postuler(Request $request, $id)
    {
        $marche = Market::findOrFail($id);

        if ($marche->candidature_end_date && now()->greaterThan($marche->candidature_end_date)) {
            return redirect()->back()->with('error', 'La date limite de dépôt des dossiers pour ce marché est dépassée.');
        }

        $validated = $request->validate([
            'nom_candidat'              => 'required|string|max:255',
            'email_candidat'            => 'required|email|max:255',
            'numero_registre_commerce'  => 'required|string|max:100',
            'file_rccm'                 => 'required|file|max:10240',
            'file_acte_constitution'    => 'nullable|file|max:10240',
            'file_dfe'                  => 'required|file|max:10240',
            'file_arf'                  => 'required|file|max:10240',
            'file_cnps'                 => 'required|file|max:10240',
            'file_attestation_bancaire' => 'required|file|max:10240',
            'proposition_financiere'    => 'required|numeric|min:0',
        ]);

        $pathRccm     = $request->file('file_rccm')->store('candidatures/rccm', 'public');
        $pathDfe      = $request->file('file_dfe')->store('candidatures/dfe', 'public');
        $pathArf      = $request->file('file_arf')->store('candidatures/arf', 'public');
        $pathCnps     = $request->file('file_cnps')->store('candidatures/cnps', 'public');
        $pathBancaire = $request->file('file_attestation_bancaire')->store('candidatures/attestations_bancaires', 'public');
        $pathActeConstitution = $request->hasFile('file_acte_constitution')
            ? $request->file('file_acte_constitution')->store('candidatures/actes_constitution', 'public')
            : null;

        $budgetMax = $marche->besoin_financier_fcfa ?? $marche->besoin_financier ?? 0;

        $estConformeFinancierement = true;
        $motif = "Dossier complet et offre financière conforme au budget.";

        if ($budgetMax > 0 && $validated['proposition_financiere'] > $budgetMax) {
            $estConformeFinancierement = false;
            $motif = "Offre financière supérieure au besoin financier du marché (" . number_format($budgetMax, 0, ',', ' ') . " FCFA).";
        }

        Candidature::create([
            'marche_id'                 => $marche->id,
            'nom_candidat'              => $validated['nom_candidat'],
            'email_candidat'            => $validated['email_candidat'],
            'numero_registre_commerce'  => $validated['numero_registre_commerce'],
            'file_rccm'                 => $pathRccm,
            'file_acte_constitution'    => $pathActeConstitution,
            'file_dfe'                  => $pathDfe,
            'file_arf'                  => $pathArf,
            'file_cnps'                 => $pathCnps,
            'file_attestation_bancaire' => $pathBancaire,
            'proposition_financiere'    => $validated['proposition_financiere'],
            'statut_candidature'        => $estConformeFinancierement ? 'accepté' : 'refusé',
            'statut_marche'             => 'en attente',
            'motif_statut'              => $motif,
        ]);

        return redirect()->back()->with('success', 'Votre candidature a été transmise avec succès et sera examinée lors du dépouillement public de la COJO.');
    }

    public function candidatureIndex()
    {
        $candidatures = Candidature::with('market')->latest()->paginate(15);
        return view('profile.menus.candidatures.liste', compact('candidatures'));
    }

    /**
     * Arbitrage et Attribution Provisoire par la COJO (Comité d'Ouverture et de Jugement des Offres)
     */
    public function arbitrer($marcheId)
    {
        // Sécurité : Seuls les membres habilités COJO ou l'administration peuvent arbitrer
        $userRole = auth()->user()->role->name ?? '';
        if (!in_array($userRole, ['cojo', 'cojo_analyse', 'comite_technique'])) {
            abort(403, 'Action non autorisée. Seule la COJO est habilitée à attribuer provisoirement le marché.');
        }

        $marche = Market::with('candidatures')->findOrFail($marcheId);
        $candidaturesValides = $marche->candidatures()->where('statut_candidature', 'accepté')->get();

        if ($candidaturesValides->isEmpty()) {
            return redirect()->back()->with('error', 'Aucune candidature valide pour procéder à l\'attribution.');
        }

        // Désignation du moins-disant par le comité d'analyse
        $moinsDisant = $candidaturesValides->sortBy('proposition_financiere')->first();

        foreach ($candidaturesValides as $candidature) {
            if ($candidature->id === $moinsDisant->id) {
                $candidature->update([
                    'statut_marche' => 'tributaire',
                    'motif_statut'  => 'Attribution provisoire retenue par la COJO (moins-disant).'
                ]);

                if (!empty($candidature->email_candidat)) {
                    try {
                        Mail::to($candidature->email_candidat)->send(new NotificationAttributionMarche($candidature, true));
                    } catch (\Exception $e) {
                        \Log::error("Erreur d'envoi d'e-mail (attributaire provisoire) : " . $e->getMessage());
                    }
                }
            } else {
                $candidature->update([
                    'statut_marche' => 'rejeté',
                    'motif_statut'  => 'Offre non retenue à l\'issue de l\'analyse de la COJO.'
                ]);

                if (!empty($candidature->email_candidat)) {
                    try {
                        Mail::to($candidature->email_candidat)->send(new NotificationAttributionMarche($candidature, false));
                    } catch (\Exception $e) {
                        \Log::error("Erreur d'envoi d'e-mail (rejet) : " . $e->getMessage());
                    }
                }
            }
        }

        // Mise à jour automatique des jalons du marché (Attribution provisoire + Ouverture de la période ANRMPCI de 7 jours)
        $marche->update([
            'etape'                       => 'ATTRIBUTION_PROVISOIRE',
            'date_attribution_provisoire' => now(),
            'fin_periode_contestation'    => now()->addDays(7), // 7 jours de recours légal
        ]);

        return redirect()->back()->with('success', 'Attribution provisoire prononcée par la COJO. La période de recours ANRMPCI de 7 jours est ouverte.');
    }

    public function evaluer(Request $request, Candidature $candidature)
    {
        $userRole = auth()->user()->role->name ?? '';
        if (!in_array($userRole, ['cojo', 'cojo_analyse', 'comite_technique'])) {
            abort(403, 'Action non autorisée.');
        }

        $validated = $request->validate([
            'statut_candidature' => 'required|in:accepté,refusé',
            'statut_marche'      => 'required|in:en attente,tributaire,rejeté',
            'motif_statut'       => 'nullable|string',
        ]);

        $candidature->update([
            'statut_candidature' => $validated['statut_candidature'],
            'statut_marche'      => $validated['statut_marche'],
            'motif_statut'       => $validated['motif_statut'] ?? $candidature->motif_statut,
        ]);

        if (!empty($candidature->email_candidat)) {
            try {
                Mail::to($candidature->email_candidat)
                    ->send(new NotificationStatutCandidature($candidature));
            } catch (\Exception $e) {
                \Log::error("Erreur d'envoi d'e-mail : " . $e->getMessage());
            }
        }

        return redirect()->back()->with('success', 'Évaluation mise à jour avec succès.');
    }
}