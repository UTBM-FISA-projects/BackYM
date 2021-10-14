<?php

namespace Database\Factories;

use App\Models\Proposal;
use App\Models\User;
use App\Models\Yard;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProposalFactory extends Factory
{
    protected $model = Proposal::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'id_yard' => Yard::all()
                ->random()
                ->id_yard,
            'id_recipient' => User::all()->random()->id_user,
            'accepted' => $this->faker->boolean(30),
        ];
    }
}
