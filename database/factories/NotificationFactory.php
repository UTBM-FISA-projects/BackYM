<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'creation' => $this->faker->dateTime,
            'is_read' => $this->faker->boolean,
            'parameters' => ['enterprise' => 2, 'project_owner' => 1, 'yard' => 1],
            'id_recipient' => User::all()->random()->id_user,
            'id_notification_type' => NotificationType::all()->random()->id_notification_type,
        ];
    }
}
