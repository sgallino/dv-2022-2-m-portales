<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property int $pais_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $sinopsis
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pais $pais
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereFechaEstreno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePeliculaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePortada($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePortadaDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereSinopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereTitulo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePaisId($value)
 */
class Pelicula extends Model
{
    // HasFactory sirve si definimos una clase "Factory" asociada, que son útiles para fines de testing.
    // Como no vamos a estar usando testing por ahora, la podemos comentar.
//    use HasFactory;

    // Por defecto, Laravel supone que el nombre de la tabla asociada al modelo es el mismo nombre que la
    // clase, en minúsculas y en plural (del inglés).
    // Si queremos indicar a mano el nombre de la tabla, solamente tenemos que definir la propiedad
    // $table.
    protected $table = 'peliculas';

    // Por defecto, Laravel supone que la PK de la tabla se llama "id". De no ser así, lo podemos indicar
    // con la propiedad $primaryKey.
    protected $primaryKey = 'pelicula_id';

    // Definimos la lista "blanca" de las propiedades que aceptamos nos cargue de manera masiva cuando hacemos
    // un create/update con Eloquent.
    protected $fillable = ['titulo', 'precio', 'fecha_estreno', 'sinopsis', 'portada', 'portada_descripcion'];

    public const VALIDATE_RULES = [
//            'titulo' => ['required', 'min:2'],
        'titulo' => 'required|min:2',
        'precio' => 'required|numeric|min:0',
        'fecha_estreno' => 'required',
    ];

    public const VALIDATE_MESSAGES = [
        'titulo.required' => 'El título debe llevar un valor.',
        'titulo.min' => 'El título debe tener al menos :min caracteres.',
        'precio.required' => 'El precio debe llevar un valor.',
        'precio.numeric' => 'El precio debe ser un número.',
        'precio.min' => 'El precio debe ser un valor positivo.',
        'fecha_estreno.required' => 'La fecha de estreno debe llevar un valor.',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relaciones
     |--------------------------------------------------------------------------
     | Las relaciones las definimos como un método que retorne el tipo de la
     | relación con su respectiva configuración.
     | El nombre del método es esencial, porque es el identificador de la
     | relación. Esto significa que Laravel va a usar ese nombre tanto para la
     | propiedad para acceder al modelo luego, como para identificarla en ciertas
     | funcionalidades.
     |
     | Por ejemplo, para la relación con la tabla de [paises], podemos crear un
     | método pais() que retorne una llamada al método "belongsTo".
     */
    public function pais()
    {
        // belongsTo define la relación de 1:n en la tabla referenciante.
        // Nos interesan 3 parámetros que puede recibir.
        // 1. String. El FQN de la clase que representa la tabla relacionada.
        // 2. Opcional. String. El nombre del campo de la FK.
        // 3. Opcional. String. El nombre del campo de la PK referenciada.
        return $this->belongsTo(Pais::class, 'pais_id', 'pais_id');
    }
}
