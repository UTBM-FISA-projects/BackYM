<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function show($authUser, User $requestedUser): bool
    {
        return $authUser->id_user === $requestedUser->id_user;
    }

    public function getYards($authUser, User $requestedUser): bool
    {
        return $authUser->id_user === $requestedUser->id_user;
    }

    /**
     * Seule les entreprises ont des disponibilitées
     *
     * @param                  $authUser
     * @param \App\Models\User $requestedUser
     * @return bool
     */
    public function getAvailabilities($authUser, User $requestedUser): bool
    {
        return $authUser->id_user === $requestedUser->id_user
            && $authUser->type === 'enterprise';
    }
}
