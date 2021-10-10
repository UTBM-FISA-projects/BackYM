<?php

namespace Database\Seeders;

use Database\Factories\DisponibiliteFactory;
use Illuminate\Database\Seeder;

class DisponibiliteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DisponibiliteFactory::times(20)->create();
    }
}
