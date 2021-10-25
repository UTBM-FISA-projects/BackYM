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
     * Met à jour une disponibilité.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $availability = Availability::query()->findOrFail($id);

        $this->authorize('update', $availability);

        $attributes = $this->validate($request, [
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
        ]);

        $availability->update($attributes);
        return self::updated($availability);
    }

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

        Availability::query()->upsert(
            $attributes->toArray(),
            ['id_availability'],
            ['start', 'end', 'id_user']
        );

        $user = User::query()->findOrFail($id_user);
        return self::updated($user->availabilities->paginate());
    }

    /**
     * Créé une disponibilité.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->authorize('create');

        $attributes = $this->validate($request, [
            'start' => 'required|date|before:end',
            'end' => 'required|date|after:start',
        ]);

        $availability = new Availability($attributes);
        $availability->id_user = Auth::user()->id_user;

        $availability->save();
        return self::created($availability);
    }

    /**
     * Supprime une disponibilité depuis son ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(int $id): JsonResponse
    {
        $availability = Availability::query()->findOrFail($id);

        $this->authorize('delete', $availability);

        $availability->delete();
        return self::deleted();
    }
}
