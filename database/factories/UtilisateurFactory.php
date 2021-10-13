<?php

namespace Database\Factories;

use \App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class UtilisateurFactory extends Factory
{
    protected $model = Utilisateur::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->name,
            'description' => $this->faker->optional->text(),
            'type' => $this->faker->randomElement(['moa', 'ets', 'cdt']),
            'mail' => $this->faker->email,
            'telephone' => $this->faker->optional->phoneNumber(),
            'password' => $this->faker->sha256,
            'token' => null,
            'token_gentime' => null,
            'id_entreprise' => null,
        ];
    }
}
