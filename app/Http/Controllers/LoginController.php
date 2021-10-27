<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController extends BaseController
{
    /**
     * Authentifie un utilisateur depuis une combinaison email, mot de passe.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        $user = User::query()
            ->where('email', $request->json('email'))
            ->where('password', $request->json('password'))
            ->first();

        if (!$user) {
            return self::unauthorized();
        }

        $token = Str::random(255);

        $user->token = $token;
        $user->token_gentime = Carbon::now();
        $user->save();

        return self::ok(null)->cookie(
            new Cookie(
                'token',
                $token,
                Carbon::now()->addHours(24),
                '/',
                null,
                !env("APP_DEBUG"),
                true,
            )
        );
    }

    /**
     * Déconnecte un client du site en supprimant le token front et back.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $user->token = null;
        $user->token_gentime = null;
        $user->save();

        return self::ok(null)->cookie(
            new Cookie(
                'token',
                null,
                Carbon::createFromTimestamp(0),
                '/',
                null,
                !env("APP_DEBUG"),
                true,
            )
        );
    }
}
