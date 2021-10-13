<?php

namespace Database\Factories;

use App\Models\Chantier;
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
            'id_chantier' => Chantier::all()
                ->random()
                ->id_chantier,
            'id_destinataire' => Utilisateur::all()->random()->id_utilisateur,
            'accepter' => $this->faker->boolean(30),
        ];
    }
}
