<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

// Para poder usar las funcionalidades de autenticación de Laravel, nuestro modelo debe heredar de la clase
// User interna de Laravel (no la que tenemos en la carpeta Models), en vez de la clase Model de Eloquent.
class Usuario extends User
{
//    use HasFactory;
    // Agregamos los traits que Laravel puede esperar encontrar.
    use HasApiTokens, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    // Declaramos qué campos Laravel debe omitir al "serializar" una instancia de esta clase.
    // "Serialización" es el proceso de transformar una estructura de datos a un formato en string, que debe
    // poder revertirse para regenerar el valor original. Por ejemplo, json_encode y json_decode.
    protected $hidden = ['password', 'remember_token'];
}
