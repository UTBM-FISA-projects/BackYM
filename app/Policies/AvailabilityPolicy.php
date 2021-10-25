<?php

namespace App\Policies;

class AvailabilityPolicy
{
    public function massUpdate($user): bool
    {
        return $user->type === 'enterprise';
    }
}
