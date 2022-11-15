<?php

namespace Tests\Unit;

use App\Cart\Carrito;
use App\Cart\CarritoItem;
use App\Models\Pelicula;
use PHPUnit\Framework\TestCase;

class CarritoTest extends TestCase
{
    public function test_puedo_agregar_un_carritoitem_al_carrito()
    {
        $id = 1;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $item = new CarritoItem($pelicula);
        $carrito = new Carrito;

        $carrito->agregarProducto($item);

        // Verificamos que haya exactamente un elemento en el carrito.
        $this->assertCount(1, $carrito->getItems());
        // Verificamos que el ítem en la posición 0 sea el producto con id $id.
//        $this->assertEquals($id, $carrito->getItems()[0]->getProducto()->pelicula_id);
        // Verificamos que el ítem en la posición 0 sea el mismo exacto ítem que pasamos al constructor.
        // assertEquals funciona haciendo las comparaciones con "==" (solo compara valores). En el caso de
        // objetos, compara que los valores de las propiedades de los objetos sean los mismos.
        // Con lo cual, dos objetos diferentes pero que tengan las mismas propiedades con los mismos
        // valores, se consideran "equivalentes".
//        $this->assertEquals($item, $carrito->getItems()[0]);
        // assertSame funciona haciendo las comparaciones con "===". Como tal, si le pido comparar objetos,
        // lo hace por _referencia_.
        $this->assertSame($item, $carrito->getItems()[0]);

        // Verificamos que podemos buscar el ítem por su id.
        $this->assertSame($item, $carrito->getItem($id));

        return $carrito;
    }

    /**
     * @depends test_puedo_agregar_un_carritoitem_al_carrito
     */
    public function test_puedo_agregar_otro_carritoitem_diferente_al_carrito(Carrito $carrito)
    {
        $id = 4;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $item = new CarritoItem($pelicula);

        $carrito->agregarProducto($item);

        $this->assertCount(2, $carrito->getItems());
        $this->assertSame($item, $carrito->getItems()[1]);
        $this->assertSame($item, $carrito->getItem($id));

        return $carrito;
    }

    /**
     * @depends test_puedo_agregar_otro_carritoitem_diferente_al_carrito
     */
    public function test_puedo_agregar_otro_carritoitem_repetido_al_carrito(Carrito $carrito)
    {
        $id = 1;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $item = new CarritoItem($pelicula);

        $carrito->agregarProducto($item);

        $this->assertCount(2, $carrito->getItems());
        $this->assertEquals(2, $carrito->getItem($id)->getCantidad());

        return $carrito;
    }

    /**
     * @depends test_puedo_agregar_otro_carritoitem_repetido_al_carrito
     */
    public function test_puedo_eliminar_un_producto_del_carrito_por_su_id(Carrito $carrito)
    {
        $id = 1;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $item = new CarritoItem($pelicula);

        $carrito->eliminarProducto($item);

        $this->assertCount(1, $carrito->getItems());
        $this->assertNull($carrito->getItem($id));

        return $carrito;
    }

    /**
     * @depends test_puedo_eliminar_un_producto_del_carrito_por_su_id
     */
    public function test_puedo_modificar_la_cantidad_de_un_carritoitem_por_un_valor_fijo(Carrito $carrito)
    {
        $id = 4;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $item = new CarritoItem($pelicula);

        $nuevaCantidad = 7;
        $carrito->setCantidad($item, $nuevaCantidad);

        $this->assertEquals($nuevaCantidad, $carrito->getItem($id)->getCantidad());

        return $carrito;
    }

    /**
     * @depends test_puedo_eliminar_un_producto_del_carrito_por_su_id
     */
    public function test_puedo_incrementar_la_cantidad_de_un_item_en_1(Carrito $carrito)
    {
        $id = 4;
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $item = new CarritoItem($pelicula);

        $carrito->incrementarCantidad($item);

        $this->assertEquals(8, $carrito->getItem($id)->getCantidad());
    }
}
