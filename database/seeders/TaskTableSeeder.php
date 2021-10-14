<?php

namespace Database\Seeders;

use Database\Factories\TaskFactory;
use Illuminate\Database\Seeder;

class TaskTableSeeder extends Seeder
{

    public function run()
    {
        TaskFactory::times(20)->create();
    }
}
