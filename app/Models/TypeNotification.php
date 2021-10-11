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
}
