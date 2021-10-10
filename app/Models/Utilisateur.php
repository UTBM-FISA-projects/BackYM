<?php

namespace App\Models;

class Utilisateur extends BaseModel
{
    protected $fillable = [
        'nom',
        'description',
        'mail',
        'telephone',
    ];

    protected $visible = [
        'id_utilisateur',
        'nom',
        'description',
        'type',
        'mail',
        'telephone',
        'id_entreprise',
    ];
}
