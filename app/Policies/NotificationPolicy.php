<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\User;

class NotificationPolicy
{
    public function setRead(User $user, Notification $notification): bool
    {
        return $notification->id_recipient === $user->id_user;
    }
}
