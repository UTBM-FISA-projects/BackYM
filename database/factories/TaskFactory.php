<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Yard;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name,
            'description' => $this->faker->optional->text(),
            'state' => $this->faker->randomElement(['todo', 'doing', 'done']),
            'estimated_time' => $this->faker->time('H:i'),
            'time_spent' => $this->faker->time('H:i'),
            'start_planned_date' => $this->faker->dateTime,
            'end_planned_date' => $this->faker->dateTime,
            'supervisor_validated' => $this->faker->boolean,
            'executor_validated' => $this->faker->boolean(80),
            'id_yard' => Yard::all()
                ->random()
                ->id_yard,
            'id_executor' => User::query()
                ->where('type', 'enterprise')
                ->get()
                ->random()
                ->id_user,
        ];
    }
}
