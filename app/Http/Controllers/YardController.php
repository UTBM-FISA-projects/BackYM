<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Proposal;
use App\Models\Yard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class YardController extends BaseController
{
    /**
     * Récupère les missions d'un chantier depuis son ID.
     *
     * @param int $id ID du chantier
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getTasks(Request $request, int $id): JsonResponse
    {
        $yard = Yard::query()->findOrFail($id);

        $this->authorize('getTasks', $yard);

        $this->validate($request, [
            'state' => 'in:todo,doing,done',
        ]);

        $state = $request->query('state');

        return self::ok(
            $yard
                ->tasks
                ->when($state, function (Collection $query, $state) {
                    return $query->where('state', $state);
                })
                ->paginate()
        );
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
        $this->authorize('create', Yard::class);

        $attributes = $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'deadline' => 'nullable|date|after:now',
            'archived' => 'prohibited',
            'id_supervisor' => 'nullable|integer|exists:user,id_user',
            'proposals.*' => 'integer',
        ]);

        $yard = DB::transaction(function () use ($attributes, $request) {
            // adding new yard
            $yard = new Yard($attributes);
            $yard->id_project_owner = Auth::user()->id_user;
            $yard->save();
            $yard = $yard->fresh();

            collect($request->json('proposals', []))
                ->each(function ($id_enterprise) use ($yard) {
                    // adding new proposal
                    $prop = new Proposal();
                    $prop->id_yard = $yard->id_yard;
                    $prop->id_recipient = $id_enterprise;
                    $prop->save();

                    // adding related notification
                    Notification::createProposition(
                        $id_enterprise,
                        Auth::user()->id_user,
                        $yard->id_yard
                    );
                });

            return $yard;
        });

        return self::created($yard);
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
