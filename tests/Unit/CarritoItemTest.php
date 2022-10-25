<?php

namespace Tests\Unit;

use App\Models\Pelicula;
use PHPUnit\Framework\TestCase;

/*
 * Cada test se define como un método de la clase.
 * Las clases de tests deben, por defecto, llevar el sufijo "Test".
 * Los métodos que representan un test deben, por defecto, llevar el prefijo "test".
 * Es una práctica recomendada que los nombres de los tests sean lo más descriptivos posible de lo que el
 * test va a realizar.
 * Laravel recomienda escribir los nombres de los tests en snake_case.
 */
class CarritoItemTest extends TestCase
{
    /**
     * Test para verificar que podamos instanciar la clase de CarritoItem.
     * Normalmente, no haríamos un test para probar que una clase se pueda instanciar, pero nos sirve para
     * ver la anatomía de un test.
     *
     * @return void
     */
    public function test_puedo_instanciar_un_carrito_item_con_solo_una_pelicula()
    {
        // Los tests generalmente se componen de 3 partes:
        // 1. Definición de valores y configuración del entorno.
        // 2. Ejecución del método/función a testear.
        // 3. Verificación de expectativas.

        // 1. Definición de valores.
        // Para instanciar un CarritoItem, definimos que tiene que recibir en el constructor un objeto
        // Pelicula.
        $id = 1;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;

        // 2. Ejecución del método a testear.
        $item = new \App\Cart\CarritoItem($pelicula);

        // 3. Verificación de expectativas.
        // Estas verificaciones, en testing, las llamamos "assertions", y se suelen realizar con métodos que
        // hagan la comparación necesaria.
        // Por ejemplo, podemos verificar que $item sea una instancia de CarritoItem, y que tenga como
        // producto la película con el id que le indicamos.
        $this->assertInstanceOf(\App\Cart\CarritoItem::class, $item);
        $this->assertEquals($item->getProducto()->pelicula_id, $id);
    }
}
