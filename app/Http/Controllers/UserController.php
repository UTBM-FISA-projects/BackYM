<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    /**
     * Récupère un utilisateur selon son id
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

        $this->authorize('show', $user);

        return self::ok($user);
    }

    /**
     * Récupère les chantiers d'un utilisateur.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getYards(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

        $this->authorize('getYards', $user);

        return self::ok($user->yards->paginate());
    }

    /**
     * Récupère les disponibilités d'une entreprise.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getAvailabilities(int $id): JsonResponse
    {
        $user = User::query()->findOrFail($id);

        $this->authorize('getAvailabilities', $user);

        return self::ok($user->availabilities->paginate());
    }

    /**
     * Récupère les notifications d'un utilisateur à partir de son ID.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications(): JsonResponse
    {
        $user = User::query()->findOrFail(Auth::user()->id_user);

        return self::ok($user->notifications->paginate());
    }

    /**
     * Met à jour un utilisateur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        $attributes = $this->validate($request, [
            'name' => 'string|max:255',
        ]);

        $user = User::query()->findOrFail(Auth::user()->id_user);
        $user->update($attributes);

        return self::updated($user);
    }

    // create
}
