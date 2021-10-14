<?php

namespace Database\Seeders;

use Database\Factories\YardFactory;
use Illuminate\Database\Seeder;

class YardTableSeeder extends Seeder
{

    public function run()
    {
        YardFactory::times(20)->create();
    }
}
