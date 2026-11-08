<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PndVersion extends Model
{
    /** @use HasFactory<\Database\Factories\PndVersionFactory> */
    use HasFactory;

    protected $fillable = [
        'version',
        'start_date',
        'end_date',
        'nombre_pilier',
        'is_active',
    ];

    /**
     * Relation : Récupère la liste des piliers rattachés à cette version du PND.
     */
    public function piliers()
    {
        return $this->hasMany(PndPilier::class, 'pnd_version_id')->orderBy('numero');
    }
}