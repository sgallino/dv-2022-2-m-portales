<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
//        echo "Hola desde el Controller! :D";
        // Las vistas se invocan con el helper "view", que recibe la ruta a partir de la carpeta de
        // "vistas" (resources/views) del archivo correspondiente, sin extensión.
        // Por ejemplo, cuando hacemos un:
        //  return view('welcome');
        // Laravel va a buscar un archivo llamado:
        // - "resources/views/welcome.blade.php"
        // - "resources/views/welcome.php"
        // El ".blade" indica que está usando el sistema de templates de Laravel conocido como "Blade".
        return view('index');
    }

    public function about()
    {
        // Si la vista está en una sub-carpeta, tenemos que indicarlo en el string del parámetro, ya
        // sea usando las "/" típicas de los subdirectorios, o usando la nomenclatura de "." de Laravel.

        // Ej. 1: Usando las "/".
//        return view('home/about');

        // Ej. 2: Usando la notación de punto.
        return view('home.about');
    }
}
