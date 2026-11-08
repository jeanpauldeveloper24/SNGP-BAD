<?php

namespace App\Http\Controllers;

use App\Models\Circonscription;
use Illuminate\Http\Request;

class CirconscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère les circonscriptions avec leur parent, paginées pour l'affichage
        $circonscriptions = Circonscription::with('parent')->orderBy('type')->paginate(25);
        
        // Récupère toutes les circonscriptions pour alimenter le menu déroulant du parent
        $parents = Circonscription::orderBy('nom')->get();

        return view('profile.menus.circonscription.list', compact('circonscriptions', 'parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Circonscription::orderBy('nom')->get();
        
        // CORRIGÉ : Redirige vers la bonne vue de formulaire au lieu d'une route inexistante
        return view('profile.menus.circonscription.form', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:district_autonome,region,departement,sous_prefecture,commune',
            'parent_id' => 'nullable|exists:circonscriptions,id',
            'chef_lieu' => 'nullable|string|max:255',
            'code_officiel' => 'nullable|string|max:50',
        ]);

        Circonscription::create($validated);

        return redirect()->route('profile.menus.circonscription.list')
            ->with('success', 'La circonscription administrative a été ajoutée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Circonscription $circonscription)
    {
        $circonscription->load('parent', 'enfants');
        return view('profile.menus.circonscription.show', compact('circonscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Circonscription $circonscription)
    {
        $parents = Circonscription::where('id', '!=', $circonscription->id)->orderBy('nom')->get();
        return view('profile.menus.circonscription.form', compact('circonscription', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Circonscription $circonscription)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'type' => 'required|in:district_autonome,region,departement,sous_prefecture,commune',
            'parent_id' => 'nullable|exists:circonscriptions,id',
            'chef_lieu' => 'nullable|string|max:255',
            'code_officiel' => 'nullable|string|max:50',
        ]);

        $circonscription->update($validated);

        return redirect()->route('profile.menus.circonscription.list')
            ->with('success', 'La circonscription administrative a été mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Circonscription $circonscription)
    {
        $circonscription->delete();

        return redirect()->route('profile.menus.circonscription.list')
            ->with('success', 'La circonscription a été supprimée avec succès.');
    }
}