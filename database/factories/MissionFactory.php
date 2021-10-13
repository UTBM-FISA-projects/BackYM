<?php

namespace Database\Factories;

use App\Models\Chantier;
use App\Models\Mission;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class MissionFactory extends Factory
{
    protected $model = Mission::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'titre' => $this->faker->name,
            'description' => $this->faker->optional->text(),
            'etat' => $this->faker->randomElement(['todo', 'doing', 'done']),
            'temps_estime' => $this->faker->time('H:i'),
            'temps_passe' => $this->faker->time('H:i'),
            'debut_date_prevu' => $this->faker->dateTime,
            'fin_date_prevu' => $this->faker->dateTime,
            'valider_cdt' => $this->faker->boolean,
            'valider_executant' => $this->faker->boolean(80),
            'id_chantier' => Chantier::all()
                ->random()
                ->id_chantier,
            'id_executant' => Utilisateur::query()
                ->where('type', 'ets')
                ->get()
                ->random()
                ->id_executant,

        ];
    }
}
