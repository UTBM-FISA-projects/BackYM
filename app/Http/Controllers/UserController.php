<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use App\Models\Yard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        if ($user->type === 'enterprise') {
            return self::ok(
                Yard::query()
                    ->whereHas('tasks', function ($query) {
                        $query->where('id_executor', Auth::user()->id_user);
                    })
                    ->paginate()
            );
        }

        return self::ok($user->yards()->orderBy('archived')->orderBy('name')->paginate());
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
        $notifications = Auth::user()
            ->notifications()
            ->paginate();
        return self::ok($notifications);
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
            'siret' => 'nullable|unique:user,siret|required_if:type,enterprise|string|size:14',
            'id_enterprise' => 'integer|required_if:type,supervisor|prohibited_if:type,project_owner,enterprise|exists:user,id_user',
        ]);

        $attributes['siret'] = $request->json('siret','') == '' ? null : $attributes['siret'];

        if ($attributes['siret'] != null && !self::isValidSiret($attributes['siret'])) {

            abort(422);

        }

        $user = new User($attributes);
        $user->type = $attributes['type'];
        $user->password = $attributes['password'];
        $user->id_enterprise = $attributes['id_enterprise'] ?? null;
        $user->siret = $attributes['siret'] ?? null;

        $user->save();
        return self::created($user->fresh());
    }

    /**
     * Vérification numéro SIRET d'une entreprise grâce à l'algorithme de Luhn
     * @param string $siret
     * @return bool
     * @see https://portal.hardis-group.com/pages/viewpage.action?pageId=120357227
     */
    public static function isValidSiret(string $siret): bool // $siret est un string
    {

        if (strlen($siret) != 14 or !is_numeric($siret)) {
            return false;
        }

        $somme = 0;

        for ($x = 0; $x < 14; $x++) {

            if ($x % 2 == 0) {

                $siretx = (int)$siret[$x] * 2;

                if ($siretx >= 10) {

                    $somme += 1 + $siretx % 10;

                } else {

                    $somme += $siretx;

                }
            } else {

                $somme += (int)$siret[$x];

            }
        }

        return $somme % 10 == 0;

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
     * Récupère toutes les entreprises selon les filtres donnés.<br>
     * Recherche par nom.<br>
     * Recherche par disponibilitées.<br>
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getEnterprises(Request $request): JsonResponse
    {
        $this->validate($request, [
            'q' => 'string',
            'start_date' => 'date|before:end_date',
            'end_date' => 'date|after:start_date',
            'hours' => 'regex:/\d{2,}:[0-5]\d/',
        ]);

        // récupération des paramètres
        $start = $request->query('start_date', false);
        $end = $request->query('end_date', false);
        $hours = $request->query('hours', false);

        // récupération des ID entreprise dont les disponibilités correspondent
        $enterprises_id = Availability::query()
            ->when($start and $end, function ($query) use ($start, $end) {
                return $query
                    ->whereBetween('start', [$start, $end])
                    ->whereBetween('end', [$start, $end]);
            })
            ->groupBy('id_user')
            ->when($start and $end and $hours, function ($query) use ($hours) {
                return $query->having(
                    DB::raw('SEC_TO_TIME(SUM(TIME_TO_SEC(TIMEDIFF(end, start))))'),
                    '>',
                    $hours
                );
            })
            ->pluck('id_user');

        // récupérations des entreprises avec une recherche texte
        $enterprises = User::query()
            ->whereIn('id_user', $enterprises_id)
            ->where('type', 'enterprise')
            ->when($request->query('q'), function ($query) use ($request) {
                return $query->where('name', 'like', "%{$request->query('q')}%");
            });

        return self::ok($enterprises->paginate(
            $request->query('perPage', 15),
            ['*'],
            'page',
            $request->query('page', 1)
        ));
    }
}
