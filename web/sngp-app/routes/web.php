<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\MarketController; 
use App\Http\Controllers\UserController;   
use App\Http\Controllers\PaiementController;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Models\Candidature;
use App\Models\AuditLog;
use App\Models\Market;

/*
|--------------------------------------------------------------------------
| Routes Publiques (Accessibles à tous les visiteurs & candidats)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Page de Présentation (DSID & Équipe)
Route::get('/presentation', function () {
    return view('pages.presentation');
})->name('presentation');

// Page de fonctionnalités
Route::get('/fonctionnalites', [ProjectController::class, 'fonctionnalites'])->name('fonctionnalites');

// Contexte d'utilisation
Route::get('/contexte', function () {
    return view('pages.contexte');
})->name('contexte');

// VITRINE PUBLIQUE DES MARCHÉS : Consultations et Dépôts de candidatures
Route::get('/opportunites', [MarketController::class, 'indexPublique'])->name('pages.marches.liste');
// Route pour afficher le formulaire de candidature
Route::get('/opportunites/marche/{id}', [MarketController::class, 'showPublique'])->name('pages.candidature-form');
// Route pour traiter l'envoi du formulaire
Route::post('/opportunites/marche/{id}/postuler', [MarketController::class, 'postuler'])->name('pages.marche.postuler');

/*
|--------------------------------------------------------------------------
| Routes Protégées (Accessibles uniquement aux utilisateurs connectés)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // 0. TABLEAU DE BORD (Sécurisé)
    Route::get('/dashboard', function () {
        $projects = Project::all(); 
        return view('dashboard', compact('projects'));
    })->name('dashboard');

    // 1. GESTION DU PROFIL PERSONNEL
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. GESTION ADMINISTRATIVE DES UTILISATEURS
    Route::get('/users', [UserController::class, 'index'])->name('profile.menus.users.list');
    Route::get('/users/create', [UserController::class, 'create'])->name('profile.menus.users.create');
    Route::post('/users/store', [UserController::class, 'store'])->name('profile.menus.users.store');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('profile.menus.users.edit');
    Route::put('/users/{id}/update', [UserController::class, 'update'])->name('profile.menus.users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('profile.menus.users.destroy');

    // 3. ROUTES FINANCIÈRES ET COMPTABLES
    Route::get('/finances-budget', [ProjectController::class, 'finances'])->name('menus.finances');
    Route::get('/suivi-budgetaire', [ProjectController::class, 'budget'])->name('profile.menus.budget');

    Route::get('/comptabilite/financiere', [ProjectController::class, 'comptabiliteFinanciere'])->name('profile.menus.comptabilite.comptabilite_financiere');
    Route::get('/comptabilite/caisse', [ProjectController::class, 'comptabiliteCaisse'])->name('profile.menus.comptabilite.comptabilite_caisse');
    Route::get('/comptabilite/actif', [ProjectController::class, 'comptabiliteActif'])->name('profile.menus.comptabilite.comptabilite_actif');
    Route::get('/comptabilite/gestion', [ProjectController::class, 'comptabiliteGestion'])->name('profile.menus.comptabilite.comptabilite_gestion');
    Route::get('/comptabilite/monetaire', [ProjectController::class, 'comptabiliteMonetaire'])->name('profile.menus.comptabilite.comptabilite_monetaire');

    Route::get('/rapports', function () { return view('profile.menus.rapports'); })->name('menus.rapports');
    Route::get('/paiements', [PaiementController::class, 'index'])->name('menus.paiements');

    // 4. GESTION DU PORTEFEUILLE DES PROJETS
    // Affichage de la liste
    Route::get('/projets', [ProjectController::class, 'index'])->name('profile.menus.projects.list');

    // Affichage du formulaire de création
    Route::get('/projets/creer', [ProjectController::class, 'create'])->name('projects.create');

    // Traitement de la création
    Route::post('/projets', [ProjectController::class, 'store'])->name('projects.store');

    // Affichage du formulaire d'édition
    Route::get('/projets/{id}/editer', [ProjectController::class, 'edit'])->name('projects.edit');

    // Traitement de la mise à jour (C'est la route manquante !)
    Route::put('/projets/{id}', [ProjectController::class, 'update'])->name('projects.update');
    
    // ========================================================================
    // GESTION INTERNE DES MARCHÉS & PASSATION (PRIVÉ)
    // ========================================================================
    Route::get('/passation', [MarketController::class, 'index'])->name('passation.index');
    Route::get('/passation/create', [MarketController::class, 'create'])->name('menus.marches.create');
    Route::post('/passation', [MarketController::class, 'store'])->name('passation.store');
    // Mettre à jour le cycle de vie / étape d'un marché spécifique
    Route::get('/passation/{marche}/etape', [MarketController::class, 'editEtape'])->name('passation.edit-etape');
    Route::put('/passation/{marche}/etape', [MarketController::class, 'updateEtape'])->name('passation.update-etape');

    // 5. REGISTRE DES CANDIDATURES
    Route::get('/liste-candidatures', function () {
        $candidatures = Candidature::latest()->get();
        return view('profile.menus.candidatures.liste', compact('candidatures'));
    })->name('menus.candidatures.liste');

    Route::post('/candidatures/{id}/arbitrer', function (Request $request, $id) {
    $candidature = Candidature::findOrFail($id);

    // Exemple de logique d'arbitrage
    $candidature->update([
        'status' => $request->input('status'), // 'Accepté' ou 'Rejeté'
        'motif_statut' => $request->input('motif_statut'),
    ]);

    return back()->with('success', 'La candidature a été arbitrée avec succès.');
})->name('menus.candidatures.arbitrer');

    // 6. SYSTÈME & LOGS D'AUDIT
    Route::get('/audit', function () {
        $totalMarketsCount = class_exists(Market::class) ? Market::count() : 0;
        $certifiedCount = class_exists(Market::class) ? Market::where('status', 'Validé')->count() : 0;
        $alertCount = class_exists(Market::class) ? Market::where('status', 'En Alerte')->count() : 0;
        $logs = AuditLog::with('user')->latest()->get();

        return view('profile.menus.audit', compact('totalMarketsCount', 'certifiedCount', 'alertCount', 'logs'));
    })->name('menus.audit');

    // 7. MESSAGERIE & NOTIFICATIONS
    Route::get('/notifications', function () { return view('profile.menus.notifications'); })->name('menus.notifications');
    Route::get('/messagerie', function () { return view('profile.menus.messages'); })->name('menus.messages');

    // 8. SOUS-MENUS
    Route::get('/menus/sous-menus/historique', function () {
        return view('profile.menus.sous-menus.historique-complet');
    })->name('menus.sous-menus.historique');

});

require __DIR__.'/auth.php';