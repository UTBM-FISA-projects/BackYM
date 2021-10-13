<?php

namespace App\Models;

class Chantier extends BaseModel
{
    protected $fillable = [
        'nom' => 'string',
        'description' => 'string',
        'deadline' => 'date',
        'archiver' => 'integer',
    ];

    protected $visible = [
        'id_chantier' => 'integer',
        'nom' => 'string',
        'description' => 'string',
        'deadline' => 'date',
        'archiver' => 'integer',
        'id_moa' => 'integer',
        'id_cdt' => 'integer',
    ];

    protected $casts = [
        'id_chantier' => 'integer',
        'nom' => 'string',
        'description' => 'string',
        'deadline' => 'date',
        'archiver' => 'integer',
        'id_moa' => 'integer',
        'id_cdt' => 'integer',
    ];
}
