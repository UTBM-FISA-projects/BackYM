<?php

namespace Database\Factories;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityFactory extends Factory
{
    protected $model = Availability::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'start' => $this->faker->dateTime,
            'end' => $this->faker->dateTime,
            'id_user' => User::query()
                ->where('type', 'enterprise')
                ->get()
                ->random()
                ->id_user,
        ];
    }
}
