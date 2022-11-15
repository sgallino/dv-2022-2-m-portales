<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PeliculasAPITest extends TestCase
{
    // Le pedimos a Laravel que "refresque" la base de datos entre cada ejecución de un test.
    // Esto lo que hace es volver a correr las "migrations", pero solo las "migrations".
    // Es decir, por defecto, los "seeders" no se corren.
    use RefreshDatabase;

    // Pedimos que se ejecuten también los seeders.
    protected $seed = true;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_puedo_obtener_todas_las_peliculas()
    {
        // Para testear endpoints de la aplicación, Laravel ofrece múltiples métodos que simulan peticiones.
        // En particular, si queremos testear la aplicación "web" (lo que usaría un usuario navegando con el
        // browser), tenemos los métodos:
        // - get
        // - post
        // - put
        // - patch
        // - delete
        // - options
        // En cambio, si queremos testear una API JSON, como una API REST o RPC, podemos usar los métodos:
        // - getJson
        // - postJson
        // - putJson
        // - patchJson
        // - deleteJson
        // - optionsJson
        // La diferencia entre ambos son los métodos que la respuesta va a tener para hacer las
        // verificaciones, así como la forma en que los datos se envían.
        // En resumen, la comparación sería:
        //
        // |        | web               | API
        // | Envía  | Data como form    | JSON
        // | Recibe | HTML              | JSON
        //
        // Como queremos probar una API REST, vamos a usar los métodos que corresponden.
        // Todos los endpoints para una API, por defecto, Laravel los agrega con el prefijo "api/" en la
        // URL.
        // El "recurso" REST que vamos a testear es "peliculas".
        $response = $this->getJson('/api/peliculas');

        // Noten que las assertions se hacen sobre la respuesta obtenida, en vez de "$this".
        $response
            // Verificamos que la respuesta tenga éxito
            ->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    // El * indica que va a haber múltiples claves para esta estructura.
                    '*' => [
                        'pelicula_id',
                        'fecha_estreno',
                        'titulo',
                        'precio',
                        'sinopsis',
                        'portada',
                        'portada_descripcion',
                    ]
                ]
            ]);
    }

    public function test_puedo_obtener_una_pelicula_por_su_id()
    {
        $response = $this->getJson('/api/peliculas/1');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'pelicula_id',
                    'fecha_estreno',
                    'titulo',
                    'precio',
                    'sinopsis',
                    'portada',
                    'portada_descripcion',
                ]
            ])
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('data.titulo', 'El Señor de la Anillos: La Comunidad del Anillo')
                    ->where('data.fecha_estreno', '2000-01-11')
                    ->etc()
            );
    }

    public function test_puedo_crear_una_pelicula()
    {
        $response = $this->postJson('/api/peliculas', [
            'titulo' => 'Porco Rosso',
            'categoria_id' => 1,
            'pais_id' => 1,
            'fecha_estreno' => '1999-02-03',
            'sinopsis' => 'Un piloto de avión se transforma en un hombre-cerdo.',
            'precio' => 15.99,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson(fn (AssertableJson $json) =>
                $json
                    ->where('status', 0)
                    ->where('data.pelicula_id', 4)
                    ->where('data.pais_id', 1)
                    ->where('data.categoria_id', 1)
                    ->where('data.titulo', 'Porco Rosso')
                    ->where('data.fecha_estreno', '1999-02-03')
                    ->where('data.precio', 15.99)
                    ->where('data.sinopsis', 'Un piloto de avión se transforma en un hombre-cerdo.')
            );
    }
}
