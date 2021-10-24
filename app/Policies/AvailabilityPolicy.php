<?php

namespace App\Policies;

use App\Models\Availability;

class AvailabilityPolicy
{
    public function update($user, Availability $availability): bool
    {
        return $user->id_user === $availability->id_user;
    }

    public function create($user): bool
    {
        return $user->type === 'enterprise';
    }

    public function delete($user, Availability $availability): bool
    {
        return $user->id_user === $availability->id_user;
    }
}
