<?php

namespace Database\Seeders;

use Database\Factories\AvailabilityFactory;
use Illuminate\Database\Seeder;

class AvailabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AvailabilityFactory::times(20)->create();
    }
}
