<?php

namespace App\Policies;

use App\Models\Notification;
use App\Models\NotificationType;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function accept(User $user, Task $task): bool
    {
        $notif = Notification::query()
            ->where('parameters->task', $task->id_task)
            ->where('id_recipient', $user->id_user)
            ->where('id_notification_type', NotificationType::$TASK_PROPOSAL)
            ->first();

        return $notif !== null and $task->id_executor === null;
    }

    public function update($user, Task $task): bool
    {
        return $user->id_user === $task->id_executor
            || $user->id_user === $task->yard->id_supervisor;
    }

    public function create($user): bool
    {
        return $user->type === 'supervisor';
    }
}
