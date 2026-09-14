<?php

namespace App\Models;
use App\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Travaux extends Model
{
    use Loggable;
    // On force la table sur "travaux"
    protected $table = 'travaux';

    protected $fillable = [
        'datetime',
        'project_id',
        'project_module_id',
        'market_id',
        'user_id',
        'texte',
        'medias'
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(ProjectModule::class, 'project_module_id');
    }

    public function market(): BelongsTo
    {
        return $this->belongsTo(Market::class);
    }
}