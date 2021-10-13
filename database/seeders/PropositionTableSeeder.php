<?php

namespace Database\Seeders;

use Database\Factories\PropositionFactory;
use Illuminate\Database\Seeder;

class PropositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PropositionFactory::times(20)->create();
    }
}
