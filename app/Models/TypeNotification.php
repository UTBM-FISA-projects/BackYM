<?php

namespace App\Models;

class TypeNotification extends BaseModel
{
    protected $fillable = [];

    protected $visible = [
        'id_type_notification',
        'titre',
        'template',
    ];

    protected $casts = [
        'id_type_notification' => 'integer',
        'titre' => 'string',
        'template' => 'string',
    ];
}
