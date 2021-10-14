<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Yard;
use Illuminate\Database\Eloquent\Factories\Factory;

class YardFactory extends Factory
{
    protected $model = Yard::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->optional->text(),
            'deadline' => $this->faker->date,
            'archived' => $this->faker->boolean(20),
            'id_project_owner' => User::query()
                ->where('type', 'project_owner')
                ->get()
                ->random()
                ->id_user,
            'id_supervisor' => User::query()
                ->where('type', 'supervisor')
                ->get()
                ->random()
                ->id_user,

        ];
    }
}
