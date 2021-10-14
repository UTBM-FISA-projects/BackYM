<?php

namespace Database\Factories;

use App\Models\NotificationType;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationTypeFactory extends Factory
{
    protected $model = NotificationType::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'template' => $this->faker->text,
        ];
    }
}
