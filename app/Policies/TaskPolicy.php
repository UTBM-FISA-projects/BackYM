<?php

namespace App\Policies;

use App\Models\Task;

class TaskPolicy
{
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
