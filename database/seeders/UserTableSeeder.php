<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'toto',
            'type' => 'project_owner',
            'email' => 'toto@mail.com',
            'password' => hash('sha512', 'toto'),
        ]);

        User::query()->create([
            'name' => 'entreprise',
            'type' => 'enterprise',
            'email' => 'entreprise@mail.com',
            'password' => hash('sha512', 'entreprise'),
        ]);

        User::query()->create([
            'name' => 'superviseur',
            'type' => 'supervisor',
            'email' => 'superviseur@mail.com',
            'password' => hash('sha512', 'superviseur'),
            'id_enterprise' => 2,
        ]);

        User::factory()
            ->times(20)
            ->create();
    }
}
