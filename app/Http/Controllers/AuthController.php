<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function loginEjecutar(Request $request)
    {
        // TODO: Validar...

        $credenciales = $request->only('email', 'password');

        // El método attempt intenta autenticar al usuario.
        // Para hacerlo, pide un array de al menos 2 claves:
        // 1. Una clave "password" que contenga el password. Debe llamarse de esa forma.
        // 2. Una clave (o más claves) que contenga los valores necesarios para encontrar el usuario para
        //  autenticar. Por ejemplo, una clave "email" con el email del usuario, o una clave "user" o
        //  "username" con el nombre del usuario, o lo que queramos. Lo único importante es que esas claves
        //  representen campos en la tabla de usuarios, y que sirvan para identificarlos.
        if(Auth::attempt($credenciales)) {
            // Seguimos la recomendación de Laravel de regenerar el id de sesión.
            $request->session()->regenerate();

            return redirect()
                ->route('admin.peliculas.index')
                ->with('statusMessage', 'Sesión iniciada correctamente. ¡Bienvenido/a de nuevo!')
                ->with('statusType', 'success');
        }

        return redirect()
            ->route('auth.login.form')
            ->with('statusMessage', 'Las credenciales ingresadas no coinciden con nuestros registros.')
            ->with('statusType', 'danger')
            // withInput() envía todos los datos del formulario de nuevo, para que estén disponibles en la
            // función "old()".
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Siguiendo las recomendaciones de Laravel, invalidamos la sesión del usuario y regeneramos el
        // token de CSRF.
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login.form')
            ->with('statusMessage', 'Sesión cerrada correctamente. ¡Te esperamos pronto!')
            ->with('statusType', 'success');
    }
}
