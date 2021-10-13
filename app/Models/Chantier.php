<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chantier extends BaseModel
{
    protected $fillable = [
        'nom',
        'description',
        'deadline',
        'archiver',
        'id_moa',
        'id_cdt',
    ];

    protected $visible = [
        'id_chantier',
        'nom',
        'description',
        'deadline',
        'archiver',
        'cdt',
        'moa',
    ];

    protected $casts = [
        'id_chantier' => 'integer',
        'nom' => 'string',
        'description' => 'string',
        'deadline' => 'datetime',
        'archiver' => 'boolean',
        'id_moa' => 'integer',
        'id_cdt' => 'integer',
    ];

    protected $with = [
        'cdt',
        'moa',
    ];

    /**
     * Un chantier possède des missions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function missions(): HasMany
    {
        return $this->hasMany(
            Mission::class,
            'id_chantier',
            'id_chantier'
        );
    }

    /**
     * Un chantier possède un maitre d'oeuvre (demandeur)
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function moa(): HasOne
    {
        return $this->hasOne(
            Utilisateur::class,
            'id_utilisateur',
            'id_moa'
        );
    }

    /**
     * Un chantier possède un conducteur de travaux
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cdt(): HasOne
    {
        return $this->hasOne(
            Utilisateur::class,
            'id_utilisateur',
            'id_cdt'
        );
    }
}
