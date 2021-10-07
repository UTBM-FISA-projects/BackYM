<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //

    public function index()
    {
        return response([
            ["nom" => "chantier1", "description" => 'toto'],
            ["nom" => "chantier2", "description" => 'tata']
        ]);
    }

    public function get(int $id)
    {
        return response([
            "nom" => "chantier$id",
            "description" => "Le chantier $id"
        ]);
    }
}
