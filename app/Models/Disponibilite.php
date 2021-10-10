<?php

namespace App\Models;

class Disponibilite extends BaseModel
{
    protected $fillable = [
        'start',
        'end',
        'id_utilisateur',
    ];

    protected $visible = [
        'id_disponibilite',
        'start',
        'end',
        'id_utilisateur',
    ];
}
