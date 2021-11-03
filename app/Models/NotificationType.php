<?php

namespace App\Models;

class NotificationType extends BaseModel
{
    static int $PROPOSITION = 1;

    protected $fillable = [];

    protected $visible = [
        'id_notification_type',
        'title',
        'template',
    ];

    protected $casts = [
        'id_notification_type' => 'integer',
        'title' => 'string',
        'template' => 'string',
    ];
}
