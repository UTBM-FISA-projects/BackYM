<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NotificationType::query()->create([
            'id_notification_type' => 1,
            'title' => 'proposition',
            'template' => 'L\'entreprise ${entreprise} vous propose le chantier ${chantier}.',
        ]);
        NotificationType::query()->create([
            'id_notification_type' => 2,
            'title' => 'proposition_mission',
            'template' => 'L\'entreprise ${entreprise} vous propose la mission ${mission} sur le chantier ${chantier}.',
        ]);
        NotificationType::query()->create([
            'id_notification_type' => 3,
            'title' => 'overtime',
            'template' => 'La mission ${mission} à dépassée son temps estimé.',
        ]);
    }
}
