<?php

namespace App\Http\Controllers;

use App\Models\Availability;
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
