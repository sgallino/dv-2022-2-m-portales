<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Pelicula
 *
 * @property int $pelicula_id
 * @property int $pais_id
 * @property int $categoria_id
 * @property string $titulo
 * @property int $precio
 * @property string $fecha_estreno
 * @property string $sinopsis
 * @property string|null $portada
 * @property string|null $portada_descripcion
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Pais $pais
 * @property-read \App\Models\Categoria $categoria
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Genero[] $generos
 * @property-read int|null $generos_count
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
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula wherePaisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereCategoriaId($value)
 * @method static \Illuminate\Database\Query\Builder|Pelicula onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Pelicula whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Pelicula withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Pelicula withoutTrashed()
 * @mixin \Eloquent
 */
class Pelicula extends Model
{
    // HasFactory sirve si definimos una clase "Factory" asociada, que son ??tiles para fines de testing.
    // Como no vamos a estar usando testing por ahora, la podemos comentar.
//    use HasFactory;
    // El trait "SoftDeletes" habilita a Eloquent a hacer borrados "l??gicos" (soft delete) de los registros.
    // Esto es, no eliminarlos, sino marcarlos como eliminados en una columna "deleted_at".
    use SoftDeletes;

    // Por defecto, Laravel supone que el nombre de la tabla asociada al modelo es el mismo nombre que la
    // clase, en min??sculas y en plural (del ingl??s).
    // Si queremos indicar a mano el nombre de la tabla, solamente tenemos que definir la propiedad
    // $table.
    protected $table = 'peliculas';

    // Por defecto, Laravel supone que la PK de la tabla se llama "id". De no ser as??, lo podemos indicar
    // con la propiedad $primaryKey.
    protected $primaryKey = 'pelicula_id';

    // Definimos la lista "blanca" de las propiedades que aceptamos nos cargue de manera masiva cuando hacemos
    // un create/update con Eloquent.
    protected $fillable = ['pais_id', 'categoria_id', 'titulo', 'precio', 'fecha_estreno', 'sinopsis', 'portada', 'portada_descripcion'];

    public const VALIDATE_RULES = [
//            'titulo' => ['required', 'min:2'],
        'titulo' => 'required|min:2',
        'precio' => 'required|numeric|min:0',
        'fecha_estreno' => 'required',
    ];

    public const VALIDATE_MESSAGES = [
        'titulo.required' => 'El t??tulo debe llevar un valor.',
        'titulo.min' => 'El t??tulo debe tener al menos :min caracteres.',
        'precio.required' => 'El precio debe llevar un valor.',
        'precio.numeric' => 'El precio debe ser un n??mero.',
        'precio.min' => 'El precio debe ser un valor positivo.',
        'fecha_estreno.required' => 'La fecha de estreno debe llevar un valor.',
    ];

    /*
     |--------------------------------------------------------------------------
     | Relaciones
     |--------------------------------------------------------------------------
     | Las relaciones las definimos como un m??todo que retorne el tipo de la
     | relaci??n con su respectiva configuraci??n.
     | El nombre del m??todo es esencial, porque es el identificador de la
     | relaci??n. Esto significa que Laravel va a usar ese nombre tanto para la
     | propiedad para acceder al modelo luego, como para identificarla en ciertas
     | funcionalidades.
     |
     | Por ejemplo, para la relaci??n con la tabla de [paises], podemos crear un
     | m??todo pais() que retorne una llamada al m??todo "belongsTo".
     */
    public function pais()
    {
        // belongsTo define la relaci??n de 1:n en la tabla referenciante.
        // Nos interesan 3 par??metros que puede recibir.
        // 1. String. El FQN de la clase que representa la tabla relacionada.
        // 2. Opcional. String. El nombre del campo de la FK.
        // 3. Opcional. String. El nombre del campo de la PK referenciada.
        return $this->belongsTo(Pais::class, 'pais_id', 'pais_id');
    }

    public function generos()
    {
        // belongsToManu() define una relaci??n de n:m.
        // Recibe los siguientes par??metros:
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

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id', 'categoria_id');
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
     | permiten que al momento de ejecutar una funci??n, en vez de pasar los
     | argumentos seg??n el _orden_ en que est??n pidi??ndose, los pasamos aclarando
     | el _nombre_ del par??metro al que el argumento corresponde.
     | Por ejemplo, supongamos la funci??n setcookie() de php.
     | Esta funci??n recibe 7 posibles argumentos:
     |  - name, value, expires_or_options, path, domain, secure, httponly
     | Si nosotros queremos setear una cookie con solo el nombre, el valor y que
     | sea httponly, normalmente requerir??a usar los 7 argumentos, poniendo los 4
     | intermedios con sus valores por defecto a mano. Tipo:
     |  setcookie('nombre', 'valor', 0, '', '', false, true);
     | Toda la porci??n de "0, '', '', false, " es relleno necesario para cumplir
     | con la cantidad de argumentos. Sin mencionar que puede ser confuso qu?? valor
     | corresponde a qu?? par??metro.
     | Usando "named arguments", en cambio, podemos aclarar a qu?? par??metros le
     | pasamos cada valor. Cualquiera no mencionado, queda con su valor default.
     | Con setcookie, esto quedar??a:
     |  setcookie(name: 'nombre', value: 'valor', httponly: true);
     |
     | Las "arrow functions", por su parte, son similares a las de JS en su sintaxis,
     | pero tienen notables diferencias en su funci??n en php. A saber:
     | - Tienen acceso a todas las variables de la funci??n contenedora, sin necesidad
     |  de "pasarlas" con el "use".
     | - No pueden tener cuerpo, es decir, no llevan llaves.
     | - Solo pueden ejecutar una instrucci??n y retornar el valor.
     | La sintaxis es:
     |  fn (argumentos) => operaci??n
     */
    protected function precio(): Attribute
    {
        return Attribute::make(
            // Al leerlo, transformamos de centavos a d??lares.
            get: fn ($value) => $value / 100,
            // Esta arrow function es equivalente a escribir:
//            get: function($value) {
//                return $value / 100;
//            },
            // Al asignarlo, transformamos de d??lares a centavos.
            set: fn ($value) => $value * 100,
        );
    }

    /*
     |--------------------------------------------------------------------------
     | M??todos
     |--------------------------------------------------------------------------
     */
    public function getGenerosId(): array
    {
        return $this->generos->pluck('genero_id')->toArray();
    }
}
