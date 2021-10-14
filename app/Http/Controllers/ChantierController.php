<?php

namespace App\Http\Controllers;

use App\Models\Chantier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChantierController extends BaseController
{
    /**
     * Récupère les missions d'un chantier depuis son ID.
     *
     * @param int $id ID du chantier
     */
    public function getMissions(int $id): JsonResponse
    {
        return self::ok(
            Chantier::query()->findOrFail($id)->missions->paginate()
        );
    }

    /**
     * Modifie un chantier.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function put(Request $request, int $id): JsonResponse
    {
        $attributes = $this->validate($request, [
            'nom' => 'string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|datetime|after:now',
            'archiver' => 'nullable|boolean',
            'id_moa' => 'prohibited',
            'id_cdt' => 'nullable|integer|exists:utilisateur,id_utilisateur',
        ]);

        $chantier = Chantier::query()->findOrFail($id);
        $chantier->update($attributes);

        return self::updated($chantier);
    }

    /**
     * Créer un chantier
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function post(Request $request): JsonResponse
    {
        $attributes = $this->validate($request, [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after:now',
            'archiver' => 'prohibited',
            'id_moa' => 'prohibited',
            'id_cdt' => 'nullable|integer|exists:utilisateur,id_utilisateur',
        ]);

        $attributes['id_moa'] = 1; // TODO: Récupérer l'id utilisateur depuis Auth

        return self::created(
            Chantier::query()->create($attributes)->refresh()
        );
    }

    /**
     * Supprime un chantier depuis son ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        Chantier::query()->findOrFail($id)->delete();
        return self::deleted();
    }
}
