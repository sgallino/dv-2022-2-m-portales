<?php

namespace Tests\Unit;

use App\Cart\CarritoItem;
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
    public function test_puedo_instanciar_un_carrito_item_con_la_pelicula_con_id_1()
    {
        // Los tests generalmente se componen de 3 partes:
        // 1. Definición de valores y configuración del entorno.
        // 2. Ejecución del método/función a testear.
        // 3. Verificación de expectativas.

        // 1. Definición de valores.
        // Para instanciar un CarritoItem, definimos que tiene que recibir en el constructor un objeto
        // Pelicula.
        $id = 1;
//        $pelicula = new Pelicula();
//        $pelicula->pelicula_id = $id;
        $pelicula = $this->makePelicula($id);


        // 2. Ejecución del método a testear.
        $item = new \App\Cart\CarritoItem($pelicula);

        // 3. Verificación de expectativas.
        // Estas verificaciones, en testing, las llamamos "assertions", y se suelen realizar con métodos que
        // hagan la comparación necesaria.
        // Por ejemplo, podemos verificar que $item sea una instancia de CarritoItem, y que tenga como
        // producto la película con el id que le indicamos.
        $this->assertInstanceOf(\App\Cart\CarritoItem::class, $item);
        $this->assertEquals($item->getProducto()->pelicula_id, $id);
        $this->assertEquals($item->getCantidad(), 1);
    }

    public function test_puedo_instanciar_un_carrito_item_con_la_pelicula_con_id_3(): CarritoItem
    {
        // 1. Definición de valores.
        $id = 3;
//        $pelicula = new Pelicula();
//        $pelicula->pelicula_id = $id;
        $pelicula = $this->makePelicula($id);

        // 2. Ejecución del método a testear.
        $item = new \App\Cart\CarritoItem($pelicula);

        // 3. Verificación de expectativas.
        $this->assertInstanceOf(\App\Cart\CarritoItem::class, $item);
        $this->assertEquals($item->getProducto()->pelicula_id, $id);
        $this->assertEquals($item->getCantidad(), 1);

        // Retornamos el item para que pueda ser consumido por otro test,a través de las dependencias
        // de los tests de phpUnit.
        return $item;
    }

    public function test_puedo_instanciar_un_carrito_item_con_una_pelicula_y_una_cantidad()
    {
        // 1. Definición de valores.
        $id = 3;
        $cantidad = 5;
//        $pelicula = new Pelicula();
//        $pelicula->pelicula_id = $id;
//        $pelicula = $this->makePelicula($id);
        $pelicula = $this->makePelicula($id, $cantidad);


        // 2. Ejecución del método a testear.
        $item = new \App\Cart\CarritoItem($pelicula, $cantidad);

        // 3. Verificación de expectativas.
        $this->assertInstanceOf(\App\Cart\CarritoItem::class, $item);
        $this->assertEquals($item->getProducto()->pelicula_id, $id);
        $this->assertEquals($item->getCantidad(), $cantidad);
    }

    /**
     * @return void
     */
    public function test_no_puedo_instanciar_un_carrito_item_sin_una_pelicula()
    {
        // 1. y 3.
        $this->expectError();

        // 2. Ejecución del método a testear.
        $item = new \App\Cart\CarritoItem();
    }

    /**
     * @depends test_puedo_instanciar_un_carrito_item_con_la_pelicula_con_id_3
     */
    public function test_puedo_incrementar_la_cantidad_en_1(CarritoItem $item): CarritoItem
    {
        // 2.
        $item->incrementarCantidad();

        // 3.
        $this->assertEquals($item->getCantidad(), 2);

        return $item;
    }

    /**
     * @depends test_puedo_incrementar_la_cantidad_en_1
     */
    public function test_puedo_incrementar_la_cantidad_en_4(CarritoItem $item): CarritoItem
    {
        $item->incrementarCantidad(4);

        $this->assertEquals($item->getCantidad(), 6);

        return $item;
    }

    /**
     * @depends test_puedo_incrementar_la_cantidad_en_4
     */
    public function test_puedo_decrementar_la_cantidad_en_1(CarritoItem $item): CarritoItem
    {
        $item->decrementarCantidad();

        $this->assertEquals($item->getCantidad(), 5);

        return $item;
    }

    /**
     * @depends test_puedo_decrementar_la_cantidad_en_1
     */
    public function test_puedo_decrementar_la_cantidad_en_4(CarritoItem $item)
    {
        $item->decrementarCantidad(4);

        $this->assertEquals($item->getCantidad(), 1);
    }

    public function test_puedo_asignar_una_cantidad_a_un_item()
    {
        // 1.
//        $pelicula = new Pelicula;
//        $pelicula->pelicula_id = 1;
        $cantidad = 3;
        $pelicula = $this->makePelicula(1, $cantidad);
        $item = new CarritoItem($pelicula);

        // 2.
        $item->setCantidad($cantidad);

        $this->assertEquals($item->getCantidad(), $cantidad);
    }

    // Pueden notar que los pròximos dos métodos tienen la estructura en común:
    // 1. Crear la película.
    // 2. Crear el item.
    // 3. Verificar el resultado calculando precio * cantidad.
    // Es decir, hacen el mismo exacto test con un set de valores deiferntes.
    // Nuevamente, esto es algo común, y phpuunit tiene la posiblidad de ejecuta run mismo método
    // una N cantidad de veces, dependiendo los valores definidos en un "data provider".
//    public function test_puedo_obtener_el_subtotal_de_un_item()
//    {
////        $pelicula = new Pelicula();
////        $pelicula->pelicula_id = 1;
////        $pelicula->precio = 1499;
//        $pelicula = $this->makePelicula(1, 1499);
//        $cantidad = 3;
//        $item = new CarritoItem($pelicula, $cantidad);
//
//        $this->assertEquals(4497, $item->getSubtotal());
//    }
//
//    public function test_puedo_obtener_el_subtotal_de_un_item_con_otros_datos()
//    {
////        $pelicula = new Pelicula();
////        $pelicula->pelicula_id = 1;
////        $pelicula->precio = 2019;
//        $pelicula = $this->makePelicula(1, 2019);
//        $cantidad = 2;
//        $item = new CarritoItem($pelicula, $cantidad);
//
//        $this->assertEquals(4038, $item->getSubtotal());
//    }

    /**
     * @dataProvider peliculaDataProvider
     */
    public function test_puedo_obtener_el_subtotal_de_un_item(int $id, int $precio, int $cantidad, int $esprado)
    {
        $pelicula = $this->makePelicula($id, $precio);
        $item = new CarritoItem($pelicula, $cantidad);

        $this->assertEquals($esprado, $item->getSubtotal());
    }

    public function peliculaDataProvider(): array
    {
        return [
            [1, 1499, 3, 4497], // id, precio, cantidad, valor esperado.
            [1, 2019, 2, 4038], // id, precio, cantidad, valor esperado.
        ];
    }

    public function makePelicula(int $id, int $precio = 0): Pelicula
    {
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $pelicula->precio = $precio;
        return $pelicula;
    }
}
