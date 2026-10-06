<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['role', 'creator'])->orderBy('name', 'asc')->get();
        return view('profile.menus.users.list', compact('users')); 
    }

    public function create()
    {
        $roles = Role::orderBy('name', 'asc')->get(); 
        $user = new User();
        return view('profile.menus.users.form', compact('roles', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'lowercase', 'max:255', 'regex:/^.+@.+\..+$/', 'unique:users,email'],
            'phone'    => ['required', 'string', 'max:20'],
            'role_id'  => ['required', 'exists:roles,id'], 
            'password' => ['required', 'confirmed', Password::defaults()],
            'photo'    => ['nullable', 'image', 'max:5120'],
        ]);

        $role = Role::findOrFail($validated['role_id']);

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

        User::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'role_id'    => $validated['role_id'],
            'password'   => Hash::make($validated['password']),
            'photo'      => $photoBase64,
            'status'     => 'Actif',
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('profile.menus.users.list')
            ->with('success', '✅ Utilisateur créé avec succès.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::orderBy('name', 'asc')->get();
        return view('profile.menus.users.form', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:users,email,' . $user->id],
            'phone'   => ['required', 'string', 'max:20'],
            'role_id' => ['required', 'exists:roles,id'],
            'status'  => ['required', 'string', 'in:Actif,Inactif'], 
            'photo'   => ['nullable', 'image', 'max:5120'],
        ]);

        if ((int)$user->role_id !== (int)$validated['role_id']) {
            $newRole = Role::findOrFail($validated['role_id']);

            if ($newRole->name === 'ordonnateur' && User::where('role_id', $newRole->id)->count() >= 1) {
                throw ValidationException::withMessages([
                    'role_id' => 'Impossible de réattribuer ce rôle : le quota maximal d\'Ordonnateur (1) est atteint.',
                ]);
            }

            if ($newRole->name === 'administrateur_systeme' && User::where('role_id', $newRole->id)->count() >= 2) {
                throw ValidationException::withMessages([
                    'role_id' => 'Impossible de réattribuer ce rôle : le quota maximal d\'Administrateurs (2) est atteint.',
                ]);
            }
        }

        $user->name    = $validated['name'];
        $user->email   = $validated['email'];
        $user->phone   = $validated['phone'];
        $user->role_id = $validated['role_id'];
        $user->status  = $validated['status'];

        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            $user->photo = 'data:' . $file->getMimeType() . ';base64,' . base64_encode(file_get_contents($file->getRealPath()));
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Password::defaults()],
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.menus.users.list')
            ->with('success', '✅ Les informations de l\'utilisateur ont été mises à jour avec succès.');
    }

    public function destroy(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->withErrors('Vous ne pouvez pas supprimer votre propre compte.');
        }

        $user->delete();

        return redirect()->route('profile.menus.users.list')
            ->with('success', '✅ Utilisateur supprimé avec succès.');
    }
}