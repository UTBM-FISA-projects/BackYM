<?php

namespace Database\Seeders;

use App\Models\TypeNotification;
use Illuminate\Database\Seeder;

class TypeNotificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeNotification::query()->create([
            'id_type_notification' => 1,
            'titre' => 'proposition',
            'template' => 'L\'entreprise ${entreprise} vous propose le chantier ${chantier}.'
        ]);
        TypeNotification::query()->create([
            'id_type_notification' => 2,
            'titre' => 'proposition_mission',
            'template' => 'L\'entreprise ${entreprise} vous propose la mission ${mission} sur le chantier ${chantier}.'
        ]);
        TypeNotification::query()->create([
            'id_type_notification' => 3,
            'titre' => 'overtime',
            'template' => 'La mission ${mission} à dépassée son temps estimé.'
        ]);
    }
}
