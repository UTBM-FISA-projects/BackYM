<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    /**
     * Récupère l'utilisateur courrament authentifié.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showCurrent(): JsonResponse
    {
        return self::ok(Auth::user());
    }

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
        return self::ok(Auth::user()->notifications->paginate());
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
        $user = Auth::user();

        $attributes = $this->validate($request, [
            'name' => 'string|max:255',
            'description' => 'string|max:255',
            'email' => 'email|max:255|unique:App\Models\User,email,' . $user->id_user,
            'phone' => 'string|max:255',
        ]);

        $user->update($attributes);

        return self::updated($user);
    }

    /**
     * Change le mot de passe de l'utilisateur authentifié.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function changePassword(Request $request): JsonResponse
    {
        $this->validate($request, [
            'old_password' => 'required|string|max:255',
            'password' => 'required|string|confirmed|max:255',
            'password_confirmation' => 'required|string|max:255',
        ]);

        $user = User::query()
            ->where('password', $request->json('old_password'))
            ->findOrFail(Auth::user()->id_user);

        $user->password = $request->json('password');
        $user->save();

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
            'siret' =>'required_if:type,enterprise|string|size:14',
            'id_enterprise' => 'integer|required_if:type,supervisor|prohibited_if:type,project_owner,enterprise|exists:user,id_user',
        ]);

        $user = new User($attributes);
        $user->type = $attributes['type'];
        $user->password = $attributes['password'];
        $user->id_enterprise = $attributes['id_enterprise'] ?? null;

        $user->save();
        return self::created($user->fresh());
    }

    /**
     * Récupère les employés d'une entreprise
     * @param int $id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getEmployees(int $id): JsonResponse
    {
        $enterprise = User::query()->findOrFail($id);

        $this->authorize('getEmployees', $enterprise);

        $employees = User::query()->where("id_enterprise", $id)->get();

        return self::ok($employees->paginate());
    }

    /**
     * Récupère toutes les entreprises selon les filtres donnés.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getEnterprises(Request $request): JsonResponse
    {
        $this->authorize('getEnterprises', User::class);

        $enterprises = User::query()
            ->where('type', 'enterprise')
            ->when($request->query('q'), function ($query) use ($request) {
                return $query->where('name', 'like', "%{$request->query('q')}%");
            })
            ->get();

        return self::ok($enterprises->paginate());
    }

    /**
     * Vérification numéro SIRET d'une entreprise grâce à l'algorithme de Luhn
     * @param string $siret
     * @return bool
     * @see https://portal.hardis-group.com/pages/viewpage.action?pageId=120357227
     */
    public function isValidSiret(string $siret): bool // $siret est un string
    {

        if(strlen($siret)!=14 or !is_numeric($siret)){
            return false;
        }

        $somme = 0;

        for($x = 0; $x < 13; $x++){

            if($siret%2!=0){

                $siretx = (int)$siret[$x] * 2;

                if($siretx>=10){

                    $somme+= 1 + $siretx%10;

                }
                else{

                    $somme+=$siretx;

                }
            }
            else{

                $somme+=(int)$siret[$x];

            }
        }

        return $somme%10==1 or $somme%10==2;

    }
}
