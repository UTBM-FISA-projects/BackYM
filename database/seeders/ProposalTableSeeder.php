<?php

namespace Database\Seeders;

use Database\Factories\ProposalFactory;
use Illuminate\Database\Seeder;

class ProposalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProposalFactory::times(20)->create();
    }
}
