<?php

namespace Database\Factories;

use App\Models\Disponibilite;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class DisponibiliteFactory extends Factory
{
    protected $model = Disponibilite::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'start' => $this->faker->dateTime,
            'end' => $this->faker->dateTime,
            'id_utilisateur' => Utilisateur::query()
                ->where('type', 'ets')
                ->get()
                ->random()
                ->id_utilisateur
        ];
    }
}
