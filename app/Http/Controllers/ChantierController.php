<?php

namespace App\Http\Controllers;

use App\Models\Chantier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChantierController extends BaseController
{
    /**
     * Récupère les missions d'un chantier depuis son ID.
     *
     * @param int $id ID du chantier
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getMissions(int $id): JsonResponse
    {
        $chantier = Chantier::query()->findOrFail($id);

        $this->authorize('getMissions', $chantier);

        return self::ok($chantier->missions->paginate());
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
        $chantier = Chantier::query()->findOrFail($id);

        $this->authorize('update', $chantier);

        $attributes = $this->validate($request, [
            'nom' => 'string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|datetime|after:now',
            'archiver' => 'nullable|boolean',
            'id_moa' => 'prohibited',
            'id_cdt' => 'nullable|integer|exists:utilisateur,id_utilisateur',
        ]);

        $chantier->update($attributes);

        return self::updated($chantier);
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
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after:now',
            'archiver' => 'prohibited',
            'id_moa' => 'prohibited',
            'id_cdt' => 'nullable|integer|exists:utilisateur,id_utilisateur',
        ]);

        $attributes['id_moa'] = Auth::user()->id_utilisateur;

        return self::created(
            Chantier::query()->create($attributes)->fresh()
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
        $chantier = Chantier::query()->findOrFail($id);

        $this->authorize('delete', $chantier);

        $chantier->delete();
        return self::deleted();
    }
}
