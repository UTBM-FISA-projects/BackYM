<?php

namespace Database\Seeders;


use Database\Factories\MissionFactory;
use Illuminate\Database\Seeder;

class MissionTableSeeder extends Seeder
{

    public function run()
    {
        MissionFactory::times(20)->create();
    }
}
