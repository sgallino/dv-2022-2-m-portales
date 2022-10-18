<?php

namespace App\Mail;

use App\Models\Pelicula;
use App\Models\Usuario;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeliculaReservada extends Mailable
{
    use Queueable, SerializesModels;

    // Cualquier propiedad pública de esta clase va a estar automáticamente disponible en la vista del
    // email.
    public Usuario $usuario;
    public Pelicula $pelicula;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Usuario $usuario, Pelicula $pelicula)
    {
        $this->usuario = $usuario;
        $this->pelicula = $pelicula;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('no-responder@dvpeliculas.com', 'DV Películas')
            ->subject('Tu película fue reservada con éxito')
            ->view('mails.pelicula-reservada');
    }
}
