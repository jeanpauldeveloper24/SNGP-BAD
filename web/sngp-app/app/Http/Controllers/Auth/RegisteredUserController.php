<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;
class RegisteredUserController extends Controller
{
    /**
     * Affiche la vue d'inscription.
     */
    public function create(): View|RedirectResponse
    {
        $adminRole = Role::where('name', 'administrateur_systeme')->first();
        $ordonnateurRole = Role::where('name', 'ordonnateur')->first();

        $adminCount = $adminRole ? User::where('role_id', $adminRole->id)->count() : 0;
        $ordonnateurCount = $ordonnateurRole ? User::where('role_id', $ordonnateurRole->id)->count() : 0;

        // Si les deux quotas sont totalement saturés, redirection vers la page de connexion
        if ($adminCount >= 2 && $ordonnateurCount >= 1) {
            return redirect()->route('login')->with('error', 'L\'inscription publique est fermée. Quotas maximaux atteints.');
        }

        return view('auth.register');
    }

    /**
     * Traite l'inscription publique (Haute Direction / Admin).
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'    => ['required', 'string', 'max:20'],
            'role_id'  => ['required', 'exists:roles,id'],
            'password' => ['required', 'confirmed', Password::defaults()], // Correction ici
            'photo'    => ['nullable', 'image', 'max:5120'], // Max 5MB
        ]);

        $role = Role::findOrFail($request->role_id);

        // Vérification stricte des quotas avant création
        if ($role->name === 'ordonnateur' && User::where('role_id', $role->id)->count() >= 1) {
            throw ValidationException::withMessages([
                'role_id' => 'Le quota maximal d\'Ordonnateur (1) pour cette plateforme a été atteint.',
            ]);
        }

        if ($role->name === 'administrateur_systeme' && User::where('role_id', $role->id)->count() >= 2) {
            throw ValidationException::withMessages([
                'role_id' => 'Le quota maximal d\'Administrateurs Système (2) a été atteint.',
            ]);
        }

        $photoBase64 = null;

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $photoBase64 = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role_id'  => $request->role_id,
            'password' => Hash::make($request->password),
            'photo'    => $photoBase64,
            'status'   => 'Actif',
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect('/dashboard');
    }
}