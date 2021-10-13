<?php

namespace Database\Factories;

use App\Models\Chantier;
use App\Models\Utilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChantierFactory extends Factory
{
    protected $model = Chantier::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->name,
            'description' => $this->faker->optional->text(),
            'deadline' => $this->faker->dateTime,
            'archiver' => $this->faker->boolean(90),
            'id_moa' => Utilisateur::query()
                ->where('type', 'moa')
                ->get()
                ->random()
                ->id_utilisateur,
            'id_cdt' => Utilisateur::query()
                ->where('type', 'cdt')
                ->get()
                ->random()
                ->id_utilisateur,

        ];
    }
}
