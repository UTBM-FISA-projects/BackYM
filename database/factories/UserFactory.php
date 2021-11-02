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
        $type = $this->faker->randomElement(['project_owner', 'enterprise', 'supervisor']);

        return [
            'name' => $this->faker->name,
            'description' => $this->faker->optional->text(),
            'type' => $type,
            'email' => $this->faker->email,
            'phone' => $this->faker->optional->phoneNumber(),
            'password' => $this->faker->sha256,
            'token' => null,
            'token_gentime' => null,
            'siret' => null,
            'id_enterprise' => $type == 'supervisor' ?
                1
                : null,
        ];
    }
}
