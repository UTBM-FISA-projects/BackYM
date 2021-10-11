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
            UtilisateurTableSeeder::class,
            DisponibiliteTableSeeder::class,
            PropositionTableSeeder::class,
            TypeNotificationTableSeeder::class,
            NotificationTableSeeder::class,
        ]);
    }
}
