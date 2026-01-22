<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Page de Présentation (DSID & Équipe)
Route::get('/presentation', function () {
    return view('pages.presentation');
})->name('presentation');

// Page de fonctionnalités
Route::get('/fonctionnalites', function () {
    return view('pages.fonctionnalite');
})->name('fonctionnalites');

//contexte d'utilisation
Route::get('/contexte', function () {
    return view('pages.contexte');
})->name('contexte');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
