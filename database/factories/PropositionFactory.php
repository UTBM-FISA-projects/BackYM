<?php

namespace Database\Factories;

use App\Models\Proposition;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropositionFactory extends Factory
{
protected $model = Proposition::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'id_chantier' => $this->faker->numberBetween(0, 20), // TODO : utiliser la table chantier
            'id_destinataire' => Utilisateur::all()->random()->id_utilisateur,
            'accepter' => $this->faker->boolean(30),
        ];
    }
}
