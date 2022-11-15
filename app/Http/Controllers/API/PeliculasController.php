<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelicula;
use Illuminate\Http\Request;

class PeliculasController extends Controller
{
    public function list()
    {
        // Para retornar JSONs, usamos el método "json" del retorno de la función "response()".
        return response()->json([
            'data' => Pelicula::all(),
        ]);
    }

    public function get(int $id)
    {
        return response()->json([
            'data' => Pelicula::findOrFail($id),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        // TODO: Imagen, géneros...

        $pelicula = Pelicula::create($request->input());

        return response()->json([
            'status' => 0,
            'data' => $pelicula,
        ]);
    }
}
