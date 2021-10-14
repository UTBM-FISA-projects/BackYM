<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->optional->text(),
            'type' => $this->faker->randomElement(['project_owner', 'enterprise', 'supervisor']),
            'email' => $this->faker->email,
            'phone' => $this->faker->optional->phoneNumber(),
            'password' => $this->faker->sha256,
            'token' => null,
            'token_gentime' => null,
            'id_enterprise' => null,
        ];
    }
}
