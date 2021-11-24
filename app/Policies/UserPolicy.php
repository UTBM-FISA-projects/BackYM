<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Yard;

class UserPolicy
{
    public function show($authUser, User $requestedUser): bool
    {
        $entreprises_id = Yard::query()
            ->where('id_project_owner', $authUser->id_user)
            ->get()
            ->map(function ($yard) {
                return $yard->supervisor->id_enterprise;
            })
            ->unique();

        return $authUser->id_user === $requestedUser->id_user        // se demande lui-même
            || $authUser->id_enterprise === $requestedUser->id_user  // superviseur demande l'entreprise
            || $authUser->id_user === $requestedUser->id_enterprise  // entreprise demande un employé
            || $entreprises_id->contains($requestedUser->id_user);   // demande une entreprise gérante de chantier
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
    public function getEmployees(User $user, User $enterprise): bool
    {
        return $user->id_user === $enterprise->id_user && $user->type === "enterprise";
    }

    public function getEnterprises(User $user): bool
    {
        return in_array($user->type, ['project_owner', 'supervisor']);
    }
}
