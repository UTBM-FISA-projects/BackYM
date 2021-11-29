<?php

namespace App\Policies;

use App\Models\Yard;
use Illuminate\Database\Eloquent\Collection;

class YardPolicy
{
    public function getTasks($user, Yard $yard): bool
    {
        $yards = new Collection();

        if ($user->type === 'enterprise') {
            $yards = Yard::query()
                ->whereHas('tasks', function ($query) use ($user) {
                    $query->where('id_executor', $user->id_user);
                })
                ->get();
        }

        return $user->id_user === $yard->id_project_owner
            || $user->id_user === $yard->id_supervisor
            || !$yards->isEmpty();
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
