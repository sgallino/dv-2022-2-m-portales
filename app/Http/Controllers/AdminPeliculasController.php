<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;

class AdminPeliculasController extends Controller
{
    public function index()
    {
        // Traemos todas las películas usando el método "all()" de Eloquent.
        // Esto retorna una Collection que contiene una instancia por cada registro de la tabla.
        // Las Collection son, en esencia, clases "envoltorias" ("wrappers") de arrays, que los extienden
        // con muchos métodos útiles.
        $peliculas = Pelicula::all();

        // Noten que en la función view() podemos reemplazar las "/" con "." para los directorios.
        // Como vimos la primera clase, las vistas no deberían nunca buscar directamente la información,
        // se la tenemos que proveer.
        // En Laravel, hacemos esto pasando como segundo parámetro un array asociativo, donde las claves
        // van a ser los nombres de las variables que se creen en la vista.
        return view('admin.peliculas.index', [
            'peliculas' => $peliculas,
        ]);
    }

    public function nuevaForm()
    {
        return view('admin.peliculas.form-nueva');
    }

    /*
     * Para poder grabar, vamos a necesitar recibir los datos del form.
     * Si bien podríamos leerlos desde $_POST como hacíamos en php el cuatri pasado, en general se
     * recomienda siempre evitar trabajar con variables globales (incluyendo las súper-globales de php).
     * Por eso, Laravel brinda una capa de abstracción para todo lo relacionado con las peticiones del
     * usuario: la clase Request.
     * Para poder usar la clase Request, vamos a pedirle a Laravel que nos "inyecte" la clase al controller,
     * gracias a su sistema de "Inyección de Dependencias".
     * Para aprovecharlo, solamente tenemos que pedir un argumento en la función con el tipo de la clase
     * que queremos recibir indicado. En este caso, Request.
     */
    public function nuevaGrabar(Request $request)
    {
        // Obtenemos todos los datos que llegan por POST.
//        $data = $request->input();
        // El _token (el de CSRF) no lo queremos, así que podemos pedir que nos de todos menos ese.
        $data = $request->except(['_token']);

//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        // Le pedimos a Eloquent que inserte el registro.
        Pelicula::create($data);

        // Redireccionamos al listado.
        return redirect()->route('admin.peliculas.index');
    }
}
