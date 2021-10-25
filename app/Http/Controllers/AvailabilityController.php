<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends BaseController
{
    /**
     * Met à jour les disponibilités de l'utilisateur authentifié.
     * Les disponibilités non présentes dans le JSON seront supprimées de la base.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function massUpdate(Request $request): JsonResponse
    {
        $this->authorize('massUpdate');

        $this->validate($request, [
            '*.start' => 'required|date|before:*.end',
            '*.end' => 'required|date|after:*.start',
        ]);

        $id_user = Auth::user()->id_user;

        $attributes = collect($request->all())->map(function ($item) use ($id_user) {
            $item['id_availability'] = $item['id_availability'] ?? null;
            $item['id_user'] = $id_user;
            $item['start'] = new DateTime($item['start']);
            $item['end'] = new DateTime($item['end']);
            return $item;
        });

        // Supprime
        Availability::query()
            ->where('id_user', $id_user)
            ->whereNotIn('id_availability', $attributes->pluck('id_availability'))
            ->delete();

        // Met à jour ou créé
        Availability::query()->upsert(
            $attributes->toArray(),
            ['id_availability'],
            ['start', 'end', 'id_user']
        );

        $user = User::query()->findOrFail($id_user);
        return self::updated($user->availabilities->paginate());
    }
}
