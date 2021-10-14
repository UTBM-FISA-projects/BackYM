<?php

namespace App\Models;

class NotificationType extends BaseModel
{
    protected $fillable = [];

    protected $visible = [
        'id_type_notification',
        'title',
        'template',
    ];

    protected $casts = [
        'id_type_notification' => 'integer',
        'title' => 'string',
        'template' => 'string',
    ];
}
