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
        $start = $this->faker->dateTimeThisMonth('+21 days');
        $end = $this->faker->dateTimeInInterval($start, '+8 hour');

        return [
            'start' => $start,
            'end' => $end,
            'id_user' => User::query()
                ->where('type', 'enterprise')
                ->get()
                ->random()
                ->id_user,
        ];
    }
}
