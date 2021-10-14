<?php

namespace App\Http\Controllers;

use App\Models\Yard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YardController extends BaseController
{
    /**
     * Récupère les missions d'un chantier depuis son ID.
     *
     * @param int $id ID du chantier
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getTasks(int $id): JsonResponse
    {
        $yard = Yard::query()->findOrFail($id);

        $this->authorize('getTasks', $yard);

        return self::ok($yard->tasks->paginate());
    }

    /**
     * Modifie un chantier.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function put(Request $request, int $id): JsonResponse
    {
        $yard = Yard::query()->findOrFail($id);

        $this->authorize('update', $yard);

        $attributes = $this->validate($request, [
            'name' => 'string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|datetime|after:now',
            'archived' => 'nullable|boolean',
            'id_project_owner' => 'prohibited',
            'id_supervisor' => 'nullable|integer|exists:user,id_user',
        ]);

        $yard->update($attributes);

        return self::updated($yard);
    }

    /**
     * Créer un chantier
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function post(Request $request): JsonResponse
    {
        $this->authorize('create');

        $attributes = $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after:now',
            'archived' => 'prohibited',
            'id_project_owner' => 'prohibited',
            'id_supervisor' => 'nullable|integer|exists:user,id_user',
        ]);

        $attributes['id_project_owner'] = Auth::user()->id_user;

        return self::created(
            Yard::query()->create($attributes)->fresh()
        );
    }

    /**
     * Supprime un chantier depuis son ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function delete(int $id): JsonResponse
    {
        $yard = Yard::query()->findOrFail($id);

        $this->authorize('delete', $yard);

        $yard->delete();
        return self::deleted();
    }
}
