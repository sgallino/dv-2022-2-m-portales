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
 * Par indicar el método de un controller, pasamos un array como segundo parámetro, donde la primer
 * clave debe ser el nombre completo (FQN) del Controller, y el segundo el nombre del método.
 */
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('quienes-somos', [\App\Http\Controllers\HomeController::class, 'about']);
