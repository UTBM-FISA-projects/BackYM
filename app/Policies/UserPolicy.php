<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function show($authUser, User $requestedUser): bool
    {
        return $authUser->id_user === $requestedUser->id_user
            || $authUser->id_enterprise === $requestedUser->id_user
            || $authUser->id_user === $requestedUser->id_enterprise;
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

    /**
     * Vérifie l'autorisation de récupérer les employés d'une entreprise
     *
     * @param     $user
     * @param int $id
     * @return bool
     */
    public function getEmployees($user,int $id) : bool
    {
        return $user->id_user === $id && $user->type==="enterprise";
    }
}
