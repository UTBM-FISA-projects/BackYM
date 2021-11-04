<?php

namespace App\Models;

class NotificationType extends BaseModel
{
    static int $PROPOSAL = 1;
    static int $TASK_PROPOSAL = 2;

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
