<?php

namespace App\Models;

class Chantier extends BaseModel
{
    protected $fillable = [
        'nom',
        'description',
        'deadline',
        'archiver',
    ];

    protected $visible = [
        'id_chantier',
        'nom',
        'description',
        'deadline',
        'archiver',
        'id_moa',
        'id_cdt',
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
