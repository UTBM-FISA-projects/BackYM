<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            AvailabilityTableSeeder::class,
            YardTableSeeder::class,
            TaskTableSeeder::class,
            ProposalTableSeeder::class,
            NotificationTypeTableSeeder::class,
            NotificationTableSeeder::class,
        ]);
    }
}
