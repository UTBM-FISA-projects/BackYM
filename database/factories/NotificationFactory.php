<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\Utilisateur;
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
            'id_destinataire' => Utilisateur::all()->random()->id_utilisateur,
            'id_type_notification' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
