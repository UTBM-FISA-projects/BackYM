<?php

namespace App\Policies;

use App\Models\Yard;

class YardPolicy
{
    public function getTasks($user, Yard $yard): bool
    {
        return $user->id_user === $yard->id_project_owner
            || $user->id_user === $yard->id_supervisor;
    }

    public function update($user, Yard $yard): bool
    {
        return $user->id_user === $yard->id_project_owner;
    }

    public function create($user): bool
    {
        return $user->type === 'project_owner';
    }

    public function delete($user, Yard $yard): bool
    {
        return $user->id_user === $yard->id_project_owner;
    }
}
