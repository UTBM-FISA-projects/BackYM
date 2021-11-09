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
            'template' => 'Le client ${project_owner} vous propose le chantier ${yard}.',
        ]);
        NotificationType::query()->create([
            'id_notification_type' => 2,
            'title' => 'proposition_mission',
            'template' => 'Le superviseur ${supervisor} (${enterprise}) vous propose la mission ${task} sur le chantier ${yard}.',
        ]);
        NotificationType::query()->create([
            'id_notification_type' => 3,
            'title' => 'overtime',
            'template' => 'La mission ${task} à dépassée son temps estimé.',
        ]);
    }
}
