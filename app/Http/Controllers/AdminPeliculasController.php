<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPeliculasController extends Controller
{
    public function index()
    {
        // Noten que en la función view() podemos reemplazar las "/" con "." para los directorios.
        return view('admin.peliculas');
    }
}
