<?php

namespace App\Http\Controllers;

use App\Models\Pelicula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPeliculasController extends Controller
{
    public function index()
    {
        // Traemos todas las películas usando el método "all()" de Eloquent.
        // Esto retorna una Collection que contiene una instancia por cada registro de la tabla.
        // Las Collection son, en esencia, clases "envoltorias" ("wrappers") de arrays, que los extienden
        // con muchos métodos útiles.
//        $peliculas = Pelicula::all();
        /*
         |--------------------------------------------------------------------------
         | Cargando las relaciones en la consulta.
         |--------------------------------------------------------------------------
         | El método all() solo sirve para traer todos los registros de una tabla, y
         | nada más, ni nada menos.
         | Si queremos agregar cualquiera otra configuración, ya sea carga de
         | relaciones, condiciones de búsqueda, criterios de ordenamiento, etc, vamos
         | tener que llamar "get()" en su lugar, pero solo luego de haber puesto las
         | configuraciones que queremos sumarle.
         |
         | Para cargar las relaciones de manera "ansiosa" (eager loading, ver docs:
         | [https://laravel.com/docs/9.x/eloquent-relationships#eager-loading])
         | tenemos que usar el método "with()", que recibe un string o array de
         | strings con los iderntificadores de las relaciones que hay que cargar.
         */
        $peliculas = Pelicula::with(['pais'])->get();

        // Noten que en la función view() podemos reemplazar las "/" con "." para los directorios.
        // Como vimos la primera clase, las vistas no deberían nunca buscar directamente la información,
        // se la tenemos que proveer.
        // En Laravel, hacemos esto pasando como segundo parámetro un array asociativo, donde las claves
        // van a ser los nombres de las variables que se creen en la vista.
        return view('admin.peliculas.index', [
            'peliculas' => $peliculas,
        ]);
    }

    /*
     * Si queremos recibir el valor de un parámetro de la URL, simplemente tenemos que escribir como
     * argumento de la función una variable que se llame igual que el parámetro.
     */
    public function detalle(int $id)
    {
        // Buscamos la película por su id, con el método "find()".
        // Podemos, también, usar "findOrFail()".
        // find(), si no encuentra un registro con esa PK, retorna null. Si no chequemos manualmente ese
        // resultado, esto puede hacer que las vistas u otros códigos fallen.
        // findOrFail(), si no encuentra un registro, entonces automáticamente retorna un 404.
        $pelicula = Pelicula::findOrFail($id);
        return view('admin.peliculas.detalle', [
            'pelicula' => $pelicula,
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

        // Validación
        /*
         * Para validar con Laravel, tenemos un método muy práctico en la clase Request que se llama
         * "validate()".
         * Este método recibe un parámetro obligatorio que el array de las "reglas" de validación a
         * implementar. Las claves deben ser los nombres de los campos que quiero validar, y los valores
         * la lista de reglas.
         * Si las reglas pasan, el método retorna un array con los datos validados, y el programa continúa.
         * Si hay algún error, entonces:
         * - Guarda todos los mensajes de error en una variable de sesión "flash".
         * - Guarda todos los valores actuales del form en una variable de sesión "flash".
         * - Si la petición fue a través de un browser/común, entonces nos redirecciona a la página de la
         *  que vinimos.
         * - Si la petición fue por Ajax, retorna un JSON con la data, en vez de usar las variables de
         *  sesión.
         *
         * Opcionalmente, podemos pasar un segundo array con los mensajes de error que queremos para cada
         * regla.
         */
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        /*
         |--------------------------------------------------------------------------
         | Upload de la portada
         |--------------------------------------------------------------------------
         | https://laravel.com/docs/9.x/requests#files
         */
        if($request->hasFile('portada')) {
            $portada = $request->file('portada');

            // Generamos un nombre para la imagen de portada.
            // Este nombre va a ser la fecha y hora actual, seguida de un "_", seguido del título de la
            // película "sluggificado" (hecho un "slug").
            $nombrePortada = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Movemos la portada a la carpeta de imágenes.
            // public_path() retorna una ruta a partir de la carpeta "public" local del proyecto en el
            // disco del servidor.
            // Es parecido a url(), con la diferencia de que esa función retorna una ruta HTTP para ser
            // accedida por un cliente, mientras que public_path() retorna la ruta local en el servidor.
            // Versión 1: Usando el método "move".
//            $portada->move(public_path('imgs'), $nombrePortada);
            // Versión 2: Usando el "Filesystem" de Laravel, con el disco "public".
            $portada->storeAs('imgs', $nombrePortada, 'public');

            $data['portada'] = $nombrePortada;
        }

//        echo "<pre>";
//        print_r($data);
//        echo "</pre>";
        // Le pedimos a Eloquent que inserte el registro.
        // El método create() retorna una instancia de la clase con los datos insertados en la base de
        // datos.
        $pelicula = Pelicula::create($data);

        // Redireccionamos al listado.
        // Al redireccionar, podemos pasar también valores de sesión "flash" con ayuda del método "with".
        return redirect()
            ->route('admin.peliculas.index')
            ->with('statusType', 'success')
            ->with('statusMessage', 'La película <b>' . e($pelicula->titulo) . '</b> fue creada exitosamente.');
//            ->with('status', ['type' => 'success', 'message' => 'La película "' . $data['titulo'] . '" fue creada con éxito.']);
    }

    public function editarForm(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        return view('admin.peliculas.form-editar', [
            'pelicula' => $pelicula,
        ]);
    }

    public function editarEjecutar(Request $request, int $id)
    {
        $request->validate(Pelicula::VALIDATE_RULES, Pelicula::VALIDATE_MESSAGES);

        $pelicula = Pelicula::findOrFail($id);

        $data = $request->except(['_token']);

        if($request->hasFile('portada')) {
            $portada = $request->file('portada');

            // Generamos un nombre para la imagen de portada.
            $nombrePortada = date('YmdHis') . "_" . \Str::slug($data['titulo']) . "." . $portada->extension();

            // Movemos la portada a la carpeta de imágenes.
            // Versión 1: Usando el método "move".
//            $portada->move(public_path('imgs'), $nombrePortada);
            // Versión 2: Usando el "Filesystem" de Laravel, con el disco "public".
            $portada->storeAs('imgs', $nombrePortada, 'public');

            $data['portada'] = $nombrePortada;

            $portadaVieja = $pelicula->portada;
        }

        $pelicula->update($data);

        // Si había una portada vieja, entonces la eliminamos.
//        if(isset($portadaVieja) && file_exists(public_path('imgs/' . $portadaVieja))) {
        // TODO: Actualizar los defaults para Storage, y la ruta en el .env para facilitar los linkeos.
        if(isset($portadaVieja) && Storage::disk('public')->has('imgs/' . $portadaVieja)) {
            Storage::disk('public')->delete('imgs/' . $portadaVieja);
        }

        return redirect()
            ->route('admin.peliculas.index')
            ->with('statusType', 'success')
            ->with('statusMessage', 'La película <b>' . e($pelicula->titulo) . '</b> fue actualizada exitosamente.');
    }

    public function eliminarConfirmar(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);
        return view('admin.peliculas.eliminar', [
            'pelicula' => $pelicula,
        ]);
    }

    public function eliminarAccion(int $id)
    {
        $pelicula = Pelicula::findOrFail($id);

        $pelicula->delete();

        return redirect()
            ->route('admin.peliculas.index')
            ->with('statusType', 'success')
            ->with('statusMessage', 'La película <b>' . e($pelicula->titulo) . '</b> fue eliminada exitosamente.');
    }
}
