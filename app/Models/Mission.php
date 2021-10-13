<?php

namespace App\Models;

class Mission extends BaseModel
{
    protected $fillable = [
        'titre',
        'description',
        'etat',
        'temps_estime',
        'debut_date_prevu',
        'fin_date_prevu',
    ];

    protected $visible = [
        'id_mission',
        'titre',
        'description',
        'etat',
        'temps_estime',
        'temps_passe',
        'debut_date_prevu' => 'date',
        'fin_date_prevu' => 'date',
        'valider_cdt' => 'integer',
        'valider_executant' => 'integer',
        'id_executant' => 'integer',
        'id_chantier' => 'integer',
    ];

    protected $casts = [
        'id_mission' => 'integer',
        'titre' => 'string',
        'description' => 'string',
        'etat' => 'string',
        'temps_estime' => 'time',
        'temps_passe' => 'time',
        'debut_date_prevu' => 'date',
        'fin_date_prevu' => 'date',
        'valider_cdt' => 'integer',
        'valider_executant' => 'integer',
        'id_executant' => 'integer',
        'id_chantier' => 'integer',
    ];
}
