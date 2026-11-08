<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PndPilier extends Model
{
    /** @use HasFactory<\Database\Factories\PndPilierFactory> */
    use HasFactory;

    protected $fillable = [
        'pnd_version_id',
        'numero',
        'libelle',
    ];

    /**
     * Relation : Récupère la version du PND à laquelle ce pilier est rattaché.
     */
    public function version()
    {
        return $this->belongsTo(PndVersion::class, 'pnd_version_id');
    }

    /**
     * Relation : Récupère les projets rattachés à ce pilier PND.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'pnd_pilier_id');
    }
}