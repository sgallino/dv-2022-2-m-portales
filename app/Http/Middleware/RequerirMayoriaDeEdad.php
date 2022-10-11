<?php

namespace App\Http\Middleware;

use App\Models\Pelicula;
use Closure;
use Illuminate\Http\Request;

/*
 * Los Middlewares son clases comunes y corrientes, con un método "handle" que recibe 2 parámetros:
 * 1. Request $request  => El objeto de la petición, el mismo que usamos, por ejemplo, en los controllers.
 * 2. Closure $next     => El siguiente middleware a ejecutar, o el método del controller. Es imperativo
 *                         ejecutar y retornar este Closure con la petición si el middleware no quiere
 *                         cancelar la ejecución.
 *
 * Debe siempre retornar una Response o RedirectResponse.
 */
class RequerirMayoriaDeEdad
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Obtenemos la película que nos están pidiendo ver.
        // Para saber cuál es, tenemos que acceder al parámetro "id" de la ruta.
        $id = $request->route()->parameter('id');
        $pelicula = Pelicula::findOrFail($id);

        // Preguntamos si el usuario tiene indicado en una variable de sesión que es mayor de edad.
        // Esta variable la vamos a setear luego en un Controller si el usuario indica que tiene la edad
        // suficiente.
        if($pelicula->categoria_id === 4 && !\Session::has('esMayorDe18')) {
            // No indicó ser mayor de edad, así que lo redireccionamos a la pantalla de verificación.
            return redirect()->route('peliculas.confirmar-edad.form', ['id' => $id]);
        }

        return $next($request);
    }
}
