<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    public static function log(string $actionType, string $description): void
    {
        $user = Auth::user();
        
        // Détection automatique du rôle de l'acteur
        $role = 'Visiteur';
        if ($user) {
            $role = $user->role ? $user->role->name : ($user->user_role ?? 'Utilisateur');
        }

        AuditLog::create([
            'user_id'     => Auth::id(),
            'user_role'   => $role,
            'action_type' => strtoupper($actionType),
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}