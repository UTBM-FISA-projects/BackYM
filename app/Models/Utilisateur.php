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

    protected $casts = [
        'id_utilisateur' => 'integer',
        'nom' => 'string',
        'description' => 'string',
        'type' => 'string',
        'mail' => 'string',
        'telephone' => 'string',
        'password' => 'string',
        'token' => 'string',
        'token_gentime' => 'datetime',
        'id_entreprise' => 'integer',
    ];
}
