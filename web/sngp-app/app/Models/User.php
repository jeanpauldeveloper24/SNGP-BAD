<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\Loggable;

class User extends Authenticatable
{
    use Notifiable;
    use Loggable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'locale', 
        'phone',
        'photo',
        'role_id',
        'status',
        'last_connection',
        'created_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_connection' => 'datetime',
        'password' => 'hashed', // Géré nativement (Bcrypt/Argon2 ou SHA-256 selon tes configurations)
    ];

    /**
     * Relation vers le rôle de l'utilisateur.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Relation pour savoir quel Administrateur a créé ce compte.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Les utilisateurs créés par cet Administrateur.
     */
    public function createdUsers(): HasMany
    {
        return $this->hasMany(User::class, 'created_by');
    }

    /**
     * Vérifier si l'utilisateur possède un rôle spécifique
     */
    public function hasRole(string $roleName): bool
    {
        // On vérifie si l'utilisateur a un rôle chargé et si son nom correspond
        return $this->role && $this->role->name === $roleName;
    }
}