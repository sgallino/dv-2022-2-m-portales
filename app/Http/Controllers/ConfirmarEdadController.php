<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConfirmarEdadController extends Controller
{
    public function mostrarForm(int $id)
    {
        return view('peliculas.confirmar-edad', [
            'pelicula' => Pelicula::findOrFail($id),
        ]);
    }

    public function confirmarEdad(int $id)
    {
        Session::put('esMayorDe18', true);

        return redirect()
            ->route('admin.peliculas.detalle', ['id' => $id]);
    }
}
