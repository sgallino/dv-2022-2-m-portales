<?php

namespace Tests\Unit;

use App\Cart\Carrito;
use App\Cart\CarritoItem;
use App\Models\Pelicula;
use PHPUnit\Framework\TestCase;

class CarritoTest extends TestCase
{
    public function makeItem($id, $precio = 0, $cantidad = 1): CarritoItem
    {
        $pelicula = new Pelicula();
        $pelicula->pelicula_id = $id;
        $pelicula->precio = $precio;
        return new CarritoItem($pelicula, $cantidad);
    }

    public function test_puedo_agregar_un_carritoitem_al_carrito()
    {
        $id = 1;
        $item = $this->makeItem($id);
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
        $item = $this->makeItem($id);

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

        $carrito->agregarProducto($this->makeItem($id));

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
        $carrito->eliminarProducto($this->makeItem($id));

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
        $item = $this->makeItem($id);

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
        $item = $this->makeItem($id);

        $carrito->incrementarCantidad($item);

        $this->assertEquals(8, $carrito->getItem($id)->getCantidad());
    }

    public function test_puedo_vaciar_el_carrito()
    {
        $carrito = new Carrito();
        $carrito->agregarProducto($this->makeItem(1));
        $carrito->agregarProducto($this->makeItem(4));
        $carrito->agregarProducto($this->makeItem(1));
        $carrito->agregarProducto($this->makeItem(7));
        $carrito->agregarProducto($this->makeItem(12));

        $carrito->vaciar();

        $this->assertCount(0, $carrito->getItems());
    }

    public function test_puedo_obtener_el_precio_total()
    {
        $carrito = new Carrito();
        $carrito->agregarProducto($this->makeItem(1, 1500, 1));     // 1500
        $carrito->agregarProducto($this->makeItem(4, 750, 3));      // 2250
        $carrito->agregarProducto($this->makeItem(7, 2000, 2));     // 4000
        $carrito->agregarProducto($this->makeItem(12, 1000, 1));    // 100
        $total = 8750;

        $this->assertEquals($total, $carrito->getTotal());
    }
}
