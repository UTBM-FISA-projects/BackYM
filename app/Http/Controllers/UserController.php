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
     * Récupère les notifications de l'utilisateur authentifié.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNotifications(): JsonResponse
    {
        $user = User::query()->findOrFail(Auth::user()->id_user);

        return self::ok($user->notifications->paginate());
    }

    /**
     * Met à jour l'utilisateur authentifié.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request): JsonResponse
    {
        $attributes = $this->validate($request, [
            'name' => 'string|max:255',
            'description' => 'string|max:255',
            'email' => 'email|max:255|unique:user,email',
            'phone' => 'string|max:255',
        ]);

        $user = User::query()->findOrFail(Auth::user()->id_user);
        $user->update($attributes);

        return self::updated($user);
    }

    /**
     * Créer un nouvel utilisateur.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $attributes = $this->validate($request, [
            'name' => 'required|string|max:255',
            'description' => 'string|max:255',
            'type' => 'required|string|in:project_owner,enterprise,supervisor',
            'email' => 'required|email|max:255|unique:user,email',
            'phone' => 'string|max:255',
            'password' => 'required|string|confirmed|max:255',
            'password_confirmation' => 'required|string|max:255',
            'id_enterprise' => 'integer|required_if:type,supervisor|prohibited_if:type,project_owner,enterprise|exists:user,id_user',
        ]);

        $user = new User($attributes);
        $user->type = $attributes['type'];
        $user->password = $attributes['password'];
        $user->id_enterprise = $attributes['id_enterprise'] ?? null;

        $user->save();
        return self::created($user->fresh());
    }
}
