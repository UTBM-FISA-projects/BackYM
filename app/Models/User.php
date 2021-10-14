<?php

namespace App\Models;

class User extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'email',
        'phone',
    ];

    protected $visible = [
        'id_user',
        'name',
        'description',
        'type',
        'email',
        'phone',
        'id_enterprise',
    ];

    protected $casts = [
        'id_user' => 'integer',
        'name' => 'string',
        'description' => 'string',
        'type' => 'string',
        'email' => 'string',
        'phone' => 'string',
        'password' => 'string',
        'token' => 'string',
        'token_gentime' => 'datetime',
        'id_enterprise' => 'integer',
    ];
}
