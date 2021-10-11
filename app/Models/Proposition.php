<?php

namespace App\Models;

class Proposition extends BaseModel
{
    protected $fillable = [
        'accepter' => 'boolean'
    ];

    protected $visible = [
        'id_proposition' => 'integer',
        'id_chantier' => 'integer',
        'id_destinataire' => 'integer',
        'accepter' => 'boolean'
    ];

    protected $casts = [
        'id_proposition' => 'integer',
        'id_chantier' => 'integer',
        'id_destinataire' => 'integer',
        'accepter' => 'boolean'
    ];
}
