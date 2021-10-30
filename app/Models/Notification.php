<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends BaseModel
{
    protected $fillable = [
        'is_read',
    ];

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
     * Créer une notification pour une proposition de chantier
     *
     * @param int $recipient
     * @param int $enterprise
     * @param int $yard
     */
    public static function createProposition(int $recipient, int $enterprise, int $yard)
    {
        $notif = new Notification();
        $notif->id_notification_type = NotificationType::$PROPOSITION;
        $notif->id_recipient = $recipient;
        $notif->parameters = [
            'enterprise' => $enterprise,
            'yard' => $yard,
        ];
        $notif->save();
    }

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
