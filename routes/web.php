<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
 * Una "ruta" es una combinación de una URL con un método HTTP y una función o método de un Controller
 * que le corresponde.
 * Cuando el usuario ingresa a la URL con el método HTTP correcto, Laravel se va a encargar de ejecutar
 * la función o método del Controller asociado. Esa función o método de Controller es el que se encarga
 * de definir qué hay que hacer.
 *
 * Para crear rutas, Laravel nos ofrece la clase Route.
 * Esta clase tiene varios métodos que podemos acceder de manera estática (directamente de la clase).
 * Entre los métodos de la clase, tenemos los que representan los distintos métodos de HTTP:
 * get()
 * post()
 * put()
 * patch()
 * delete()
 * options()
 *
 * Cada uno de esos métodos registra una ruta para ese verbo HTTP, y recibe 2 parámetros:
 * 1. string. La URL a partir de la carpeta "public" que queremos que exista.
 * 2. Closure|array. La función o método de un controller que queremos quese ejecute al acceder a esta
 *  ruta.
 *
 * Por ejemplo, la ruta por defecto que Laravel trae:
 * Route::get('/', function () {
 *   return view('welcome');
 * });
 *
 * Registra la URL para la raíz de public por GET, y cuando se accede, se ejecuta la función que retorna
 * la vista "welcome".
 *
 * Ese ejemplo vemos que utiliza un Closure para definir lo que la vista debe hacer.
 * En general, no se recomienda usar Closures para la definición de las rutas.
 * El motivo es que de hacerlo así, este archivo rápidamente se va a volver kilométrico e inmanejable.
 * Piensen que _todas_ las rutas de la aplicación pasarían a estar definidas acá. Si sumamos cómo manejar
 * cada ruta, puedo tener cientos de miles de líneas de código en este archivo, con todo tipo de
 * responsabilidades mezcladas.
 *
 * Lo que se recomienda en general, es mapear cada ruta a un método de un Controller.
 *
 * Por ejemplo, adaptemos la función a usar un método "index" de una clase HomeController.
 */
//Route::get('/', function () {
////    echo "Hola :D";
//    return view('welcome');
//});
/*
 * Para indicar el método de un controller, pasamos un array como segundo parámetro, donde la primera
 * clave debe ser el nombre completo (FQN) del Controller, y el segundo el nombre del método.
 */
/*
 * Opcionalmente, y de manera recomendada, podemos a cada ruta asignarle un nombre único.
 * Este nombre puede ser similar a la URL de la ruta o no, y es de uso exclusivamente interno en nuestro
 * código (es decir, no se renderiza en el HTML ni nada).
 * Nos permite ponerle una suerte de "id" a cada ruta, con el que Laravel nos va a permitir referirnos a
 * ella sin importar de cuál sea la URL que le corresponda.
 */
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');
Route::get('quienes-somos', [\App\Http\Controllers\HomeController::class, 'about'])
    ->name('quienes-somos');

/*
 |--------------------------------------------------------------------------
 | Autenticación
 |--------------------------------------------------------------------------
 */
Route::get('iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginForm'])
    ->name('auth.login.form');
Route::post('iniciar-sesion', [\App\Http\Controllers\AuthController::class, 'loginEjecutar'])
    ->name('auth.login.ejecutar');
Route::post('cerrar-sesion', [\App\Http\Controllers\AuthController::class, 'logout'])
    ->name('auth.logout');

/*
 |--------------------------------------------------------------------------
 | Películas
 |--------------------------------------------------------------------------
 | Algunas rutas, como admin.peliculas.ver, van a necesitar de parámetros en la URL.
 | Los "parámetros" son segmentos de la URL cuyo valor es dinámico. Por ejemplo, los podemos usar para IDs,
 | categorías, "slugs", etc.
 | En Laravel, los parámetros de las rutas se representan con {nombre}.
 |
 | Si múltiples rutas, como en este caso, requieren configuraciones comunes (ej: qué controller usar,
 | qué middlewares usar, etc), podemos simplificar sus declaraciones usando un "grupo" de rutas.
 */
Route::middleware('auth')
    ->controller(\App\Http\Controllers\AdminPeliculasController::class)
    ->group(function() {
        // Como definimos el controller en el grupo, solo aclaramos el nombre del método en la ruta.
        Route::get('admin/peliculas', 'index')
            ->name('admin.peliculas.index');

        Route::get('admin/peliculas/papelera', 'papelera')
            ->name('admin.peliculas.papelera');

        Route::get('admin/peliculas/nueva', 'nuevaForm')
            ->name('admin.peliculas.nueva.form');

        Route::post('admin/peliculas/nueva', 'nuevaGrabar')
            ->name('admin.peliculas.nueva.grabar');

        // Para que Laravel no confunda esta ruta con la de nueva, podemos pedirle que se asegure de que sea
        // un número el {id}, o podemos mover la ruta después de la ruta de nueva. O ambas.
        Route::get('admin/peliculas/{id}', 'detalle')
            ->name('admin.peliculas.detalle')
            ->middleware('mayor.18')
        //    ->where('id', '[0-9]+');
            ->whereNumber('id');

        Route::get('admin/peliculas/{id}/editar', 'editarForm')
            ->name('admin.peliculas.editar.form')
            ->whereNumber('id');
        Route::post('admin/peliculas/{id}/editar', 'editarEjecutar')
            ->name('admin.peliculas.editar.ejecutar')
            ->whereNumber('id');

        Route::get('admin/peliculas/{id}/eliminar', 'eliminarConfirmar')
            ->name('admin.peliculas.eliminar.confirmar')
            ->whereNumber('id');
        Route::post('admin/peliculas/{id}/eliminar', 'eliminarAccion')
            ->name('admin.peliculas.eliminar.accion')
            ->whereNumber('id');

        Route::post('admin/peliculas/{id}/reservar', [\App\Http\Controllers\ReservarPeliculaController::class, 'reservar'])
            ->name('peliculas.reservar')
            ->whereNumber('id');

        Route::post('admin/peliculas/{id}/restablecer', 'restablecerEjecutar')
            ->name('admin.peliculas.restablecer.ejecutar')
            ->whereNumber('id');
    });

Route::get('admin/peliculas/{id}/confirmar-edad', [\App\Http\Controllers\ConfirmarEdadController::class, 'mostrarForm'])
    ->middleware('auth')
    ->name('peliculas.confirmar-edad.form');
Route::post('admin/peliculas/{id}/confirmar-edad', [\App\Http\Controllers\ConfirmarEdadController::class, 'confirmarEdad'])
    ->middleware('auth')
    ->name('peliculas.confirmar-edad.ejecutar');
