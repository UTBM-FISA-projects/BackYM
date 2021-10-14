<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends BaseModel
{
    protected $fillable = [];

    protected $visible = [
        'id_notification',
        'creation',
        'is_read',
        'parameters',
        'id_recipient',
        'id_notification_type',
    ];

    protected $casts = [
        'id_notification' => 'integer',
        'creation' => 'datetime',
        'is_read' => 'boolean',
        'parameters' => 'json',
        'id_recipient' => 'integer',
        'id_notification_type' => 'integer',
    ];

    /**
     * Récupère le type d'une notification.
     */
    public function notificationType(): BelongsTo
    {
        return $this->belongsTo(
            NotificationType::class,
            'id_notification_type',
            'id_notification_type'
        );
    }
}
