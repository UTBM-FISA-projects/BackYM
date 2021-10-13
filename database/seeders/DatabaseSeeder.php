<?php

namespace Database\Seeders;

use Database\Factories\MissionFactory;
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
            UtilisateurTableSeeder::class,
            DisponibiliteTableSeeder::class,
            ChantierTableSeeder::class,
            MissionFactory::class,
            PropositionTableSeeder::class,
            TypeNotificationTableSeeder::class,
            NotificationTableSeeder::class,
        ]);
    }
}
