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
        'notificationType',
    ];

    protected $casts = [
        'id_notification' => 'integer',
        'creation' => 'datetime',
        'is_read' => 'boolean',
        'parameters' => 'json',
        'id_recipient' => 'integer',
        'id_notification_type' => 'integer',
    ];

    protected $with = [
        'notificationType',
    ];

    /**
     * Mapping des paramètres à leur classe.
     *
     * @var string[]
     */
    private static array $parameters = [
        'yard' => Yard::class,
        'project_owner' => User::class,
        'enterprise' => User::class,
        'task' => Task::class,
    ];

    /**
     * Récupère les objets liés aux ID en paramètre.
     *
     * @param $paramters
     * @return array
     */
    public function getParametersAttribute($paramters): array
    {
        $params = [];

        foreach (json_decode($paramters) as $key => $value) {
            $class = Notification::$parameters[$key];
            $params[$key] = call_user_func([$class, 'query'])->find($value);
        }

        return $params;
    }

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
        $notif->notificationsParameters = [
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
