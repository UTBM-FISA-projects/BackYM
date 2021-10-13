<?php

namespace Database\Seeders;

use Database\Factories\ChantierFactory;
use Illuminate\Database\Seeder;

class ChantierTableSeeder extends Seeder
{

    public function run()
    {
        ChantierFactory::times(20)->create();
    }
}
