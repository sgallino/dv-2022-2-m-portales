<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos
 * @property-read int|null $generos_count
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
    protected $fillable = ['pais_id', 'titulo', 'precio', 'fecha_estreno', 'sinopsis', 'portada', 'portada_descripcion'];

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

    public function generos()
    {
        // belongsToManu() define una relación de n:m.
        // Recibe los siguientes parámetros:
        // 1. String. El FQN de la clase que representa la tabla relacionada.
        // 2. Opcional. String. El nombre de la tabla pivot.
        // 3. Opcional. String. El nombre de la FK en la tabla pivot que referencia a la PK de esta tabla.
        // 4. Opcional. String. El nombre de la FK en la tabla pivot que referencia a la PK de la tabla
        //  relacionada.
        // 5. Opcional. String. El nombre de la PK de esta tabla.
        // 6. Opcional. String. El nombre de la PK de la tabla relacionada.
        return $this->belongsToMany(
            Genero::class,
            'peliculas_tienen_generos',
            'pelicula_id',
            'genero_id',
            'pelicula_id',
            'genero_id',
        );
    }

    /*
     |--------------------------------------------------------------------------
     | Accessors & Mutators
     |--------------------------------------------------------------------------
     | Para definir los accesors y mutators, vamos a ver que Laravel usa dos
     | herramientas de php relativamente nuevas:
     | 1. "Named arguments/parameters".
     | 2. "Arrow functions".
     |
     | Los "named arguments" (https://www.php.net/manual/en/functions.arguments.php)
     | permiten que al momento de ejecutar una función, en vez de pasar los
     | argumentos según el _orden_ en que están pidiéndose, los pasamos aclarando
     | el _nombre_ del parámetro al que el argumento corresponde.
     | Por ejemplo, supongamos la función setcookie() de php.
     | Esta función recibe 7 posibles argumentos:
     |  - name, value, expires_or_options, path, domain, secure, httponly
     | Si nosotros queremos setear una cookie con solo el nombre, el valor y que
     | sea httponly, normalmente requeriría usar los 7 argumentos, poniendo los 4
     | intermedios con sus valores por defecto a mano. Tipo:
     |  setcookie('nombre', 'valor', 0, '', '', false, true);
     | Toda la porción de "0, '', '', false, " es relleno necesario para cumplir
     | con la cantidad de argumentos. Sin mencionar que puede ser confuso qué valor
     | corresponde a qué parámetro.
     | Usando "named arguments", en cambio, podemos aclarar a qué parámetros le
     | pasamos cada valor. Cualquiera no mencionado, queda con su valor default.
     | Con setcookie, esto quedaría:
     |  setcookie(name: 'nombre', value: 'valor', httponly: true);
     |
     | Las "arrow functions", por su parte, son similares a las de JS en su sintaxis,
     | pero tienen notables diferencias en su función en php. A saber:
     | - Tienen acceso a todas las variables de la función contenedora, sin necesidad
     |  de "pasarlas" con el "use".
     | - No pueden tener cuerpo, es decir, no llevan llaves.
     | - Solo pueden ejecutar una instrucción y retornar el valor.
     | La sintaxis es:
     |  fn (argumentos) => operación
     */
    protected function precio(): Attribute
    {
        return Attribute::make(
            // Al leerlo, transformamos de centavos a dólares.
            get: fn ($value) => $value / 100,
            // Esta arrow function es equivalente a escribir:
//            get: function($value) {
//                return $value / 100;
//            },
            // Al asignarlo, transformamos de dólares a centavos.
            set: fn ($value) => $value * 100,
        );
    }

    /*
     |--------------------------------------------------------------------------
     | Métodos
     |--------------------------------------------------------------------------
     */
    public function getGenerosId(): array
    {
        return $this->generos->pluck('genero_id')->toArray();
    }
}
