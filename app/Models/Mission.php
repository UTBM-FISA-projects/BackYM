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
        'debut_date_prevu',
        'fin_date_prevu',
        'valider_cdt',
        'valider_executant',
        'id_executant',
        'id_chantier',
    ];

    protected $casts = [
        'id_mission' => 'integer',
        'titre' => 'string',
        'description' => 'string',
        'etat' => 'string',
        'temps_estime' => 'datetime:H:i',
        'temps_passe' => 'datetime:H:i',
        'debut_date_prevu' => 'date',
        'fin_date_prevu' => 'date',
        'valider_cdt' => 'integer',
        'valider_executant' => 'integer',
        'id_executant' => 'integer',
        'id_chantier' => 'integer',
    ];
}
