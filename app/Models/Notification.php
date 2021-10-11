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
        'id_destinataire',
        'typeNotification',
    ];

    protected $casts = [
        'id_notification' => 'integer',
        'creation' => 'datetime',
        'is_read' => 'boolean',
        'id_destinataire' => 'integer',
        'id_type_notification' => 'integer',
    ];

    /**
     * Récupère le type d'une notification.
     */
    public function typeNotification(): BelongsTo
    {
        return $this->belongsTo(
            TypeNotification::class,
            'id_type_notification',
            'id_type_notification'
        );
    }
}
