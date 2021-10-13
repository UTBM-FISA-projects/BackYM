<?php

namespace App\Http\Controllers;

use App\Models\Chantier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class ChantierController extends Controller
{
    /**
     * Récupère les missions d'un chantier depuis son ID.
     *
     * @param int $id ID du chantier
     */
    public function getMissions(int $id)
    {
        return Chantier::query()->findOrFail($id)->missions;
    }

    /**
     * Modifie un chantier.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function put(Request $request, int $id)
    {
        $attributes = $this->validate($request, [
            'nom' => 'string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|datetime|after:now',
            'archiver' => 'nullable|boolean',
            'id_moa' => 'prohibited',
            'id_cdt' => 'nullable|integer|exists:utilisateur,id_utilisateur'
        ]);

        $chantier = Chantier::query()->findOrFail($id);
        $chantier->update($attributes);

        return $chantier;
    }

    /**
     * Créer un chantier
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     * @throws \Illuminate\Validation\ValidationException
     */
    public function post(Request $request)
    {
        $attributes = $this->validate($request, [
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|datetime|after:now',
            'archiver' => 'prohibited',
            'id_moa' => 'prohibited',
            'id_cdt' => 'nullable|integer|exists:utilisateur,id_utilisateur'
        ]);

        $attributes['id_moa'] = 1; // TODO: Récupérer l'id utilisateur depuis Auth

        return Chantier::query()->create($attributes)->refresh();
    }

    /**
     * Supprime un chantier depuis son ID.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function delete(int $id): Model
    {
        $chantier = Chantier::query()->findOrFail($id);
        $chantier->delete();
        return $chantier;
    }
}
