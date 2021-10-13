<?php

namespace Database\Seeders;

use Database\Factories\NotificationFactory;
use Illuminate\Database\Seeder;

class NotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationFactory::times(50)->create();
    }
}
