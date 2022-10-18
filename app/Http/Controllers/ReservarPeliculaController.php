<?php

namespace App\Http\Controllers;

use App\Mail\PeliculaReservada;
use App\Models\Pelicula;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservarPeliculaController extends Controller
{
    public function reservar(Request $request, int $id)
    {
        $pelicula = Pelicula::findOrFail($id);


        try {
            // Hacemos el envío del email.
            // Para enviar emails, usamos la façade Mail, con sus métodos to() y send().
            // El método to() va a recibir la instancia del usuario al que le queremos enviar el email.
            // Por ejemplo, si queremos el usuario autenticado, lo podemos pedir a la clase de autenticación
            // o a la instancia de Request.
            // En el método send() vamos a pasar la instancia de la clase Mailable que define el email que
            // queremos enviar.
            Mail::to($request->user())
                ->send(new PeliculaReservada($request->user(), $pelicula));

            return redirect()
                ->route('admin.peliculas.index')
                ->with('statusType', 'success')
                ->with('statusMessage', 'Tu reserva de la película <b>' . $pelicula->titulo . '</b> fue registrada correctamente.');
        } catch(\Exception $e) {
            Debugbar::error('La reserva falló con el mensaje: ' . $e->getMessage());
            return redirect()
                ->route('admin.peliculas.index')
                ->with('statusType', 'danger')
                ->with('statusMessage', 'La reserva no pudo ser realizada. Ocurrió un error imprevisto. Por favor, intentá de nuevo más tarde.');
        }
    }
}
