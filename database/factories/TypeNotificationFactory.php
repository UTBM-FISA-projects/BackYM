<?php

namespace Database\Factories;

use App\Models\TypeNotification;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use function Faker\Provider\pt_BR\check_digit;

class TypeNotificationFactory extends Factory
{
    protected $model = TypeNotification::class;

    public function definition(): array
    {
        return [
            'titre' => $this->faker->name,
            'template' => $this->faker->text,
        ];
    }
}
