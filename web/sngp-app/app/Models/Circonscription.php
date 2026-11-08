<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Circonscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'type',
        'nom',
        'chef_lieu',
        'code_officiel',
    ];

    public function parent()
    {
        return $this->belongsTo(Circonscription::class, 'parent_id');
    }

    public function enfants()
    {
        return $this->hasMany(Circonscription::class, 'parent_id');
    }

    /**
     * Relation : Récupère les projets rattachés à cette circonscription.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'circonscription_id');
    }
}