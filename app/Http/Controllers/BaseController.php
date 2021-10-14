<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller;

class BaseController extends Controller
{
    /**
     * Renvoie une réponse 200 OK avec les items en paramètre.
     *
     * @param array|mixed $item Éléments de la réponse
     * @return \Illuminate\Http\JsonResponse
     */
    public static function ok($item): JsonResponse
    {
        return response()->json($item);
    }

    /**
     * Renvoie une réponse 200 OK avec les items en paramètre.
     *
     * @param array|mixed $item
     * @return \Illuminate\Http\JsonResponse
     */
    public static function updated($item): JsonResponse
    {
        return response()->json($item);
    }

    /**
     * Renvoie une réponse 201 CREATED avec les items en paramètre
     *
     * @param array|mixed $item Éléments de la réponse
     * @return \Illuminate\Http\JsonResponse
     */
    public static function created($item): JsonResponse
    {
        return response()->json($item, 201);
    }

    /**
     * Renvoie une réponse 204 NO CONTENT.
     * Utile pour les delete.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function deleted(): JsonResponse
    {
        return response()->json([], 204);
    }
}
