<?php

namespace App\Http\Controllers;

use App\Models\PndVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PndController extends Controller
{
    /**
     * Affiche la liste des versions du PND avec leurs piliers.
     */
    public function index()
    {
        // On passe la variable sous le nom 'pndVersions' pour correspondre à votre vue
        $pndVersions = PndVersion::with('piliers')->latest()->get();

        return view('profile.menus.pnd.list', compact('pndVersions'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau PND.
     */
    public function create()
    {
        return view('profile.menus.pnd.form');
    }

    /**
     * Enregistre une nouvelle version du PND et ses piliers associés.
     */
    public function store(Request $request)
    {
        $request->validate([
            'version' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'piliers' => 'required|array|min:1',
            'piliers.*.numero' => 'required|integer',
            'piliers.*.libelle' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            // Désactiver les versions précédentes si la nouvelle devient active
            PndVersion::query()->update(['is_active' => false]);

            // Création de la version globale du PND
            $pndVersion = PndVersion::create([
                'version' => $request->version,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'nombre_pilier' => count($request->piliers),
                'is_active' => true,
            ]);

            // Création des piliers rattachés à cette version
            foreach ($request->piliers as $pilierData) {
                $pndVersion->piliers()->create([
                    'numero' => $pilierData['numero'],
                    'libelle' => $pilierData['libelle'],
                ]);
            }
        });

        return redirect()->route('profile.menus.pnd.list')
            ->with('success', 'La version du PND et ses piliers ont été configurés avec succès.');
    }

    /**
     * Affiche les détails d'une version spécifique du PND.
     */
    public function show(PndVersion $pnd)
    {
        $pnd->load('piliers');
        return view('profile.menus.pnd.show', compact('pnd'));
    }

    /**
     * Affiche le formulaire de modification d'un PND.
     */
    public function edit(PndVersion $pnd)
    {
        $pnd->load('piliers');
        return view('profile.menus.pnd.form', compact('pnd'));
    }

    /**
     * Met à jour une version du PND et ses piliers.
     */
    public function update(Request $request, PndVersion $pnd)
    {
        $request->validate([
            'version' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'piliers' => 'required|array|min:1',
            'piliers.*.numero' => 'required|integer',
            'piliers.*.libelle' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $pnd) {
            $pnd->update([
                'version' => $request->version,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'nombre_pilier' => count($request->piliers),
            ]);

            // Suppression des anciens piliers et recréation de la nouvelle liste
            $pnd->piliers()->delete();

            foreach ($request->piliers as $pilierData) {
                $pnd->piliers()->create([
                    'numero' => $pilierData['numero'],
                    'libelle' => $pilierData['libelle'],
                ]);
            }
        });

        return redirect()->route('profile.menus.pnd.list')
            ->with('success', 'La version du PND a été mise à jour avec succès.');
    }

    /**
     * Supprime une version du PND (et ses piliers par cascade).
     */
    public function destroy(PndVersion $pnd)
    {
        $pnd->delete();

        return redirect()->route('profile.menus.pnd.list')
            ->with('success', 'La version du PND a été supprimée avec succès.');
    }
}
