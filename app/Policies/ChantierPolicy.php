<?php

namespace App\Policies;

use App\Models\Chantier;

class ChantierPolicy
{
    public function getMissions($user, Chantier $chantier): bool
    {
        return $user->id_utilisateur === $chantier->id_moa
            || $user->id_utilisateur === $chantier->id_cdt;
    }

    public function update($user, Chantier $chantier): bool
    {
        return $user->id_utilisateur === $chantier->id_moa;
    }

    public function create($user): bool
    {
        return $user->type === 'moa';
    }

    public function delete($user, Chantier $chantier): bool
    {
        return $user->id_utilisateur === $chantier->id_moa;
    }
}
