<?php

namespace App\Cart;

use App\Models\Pelicula;

class Carrito
{
    /** @var CarritoItem[]  */
    private array $items = [];

    public function agregarProducto(CarritoItem $item)
    {
        $searchedItem = $this->getItem($item->getProducto()->pelicula_id);
        if($searchedItem) {
            $searchedItem->incrementarCantidad();
        } else {
            $this->items[] = $item;
        }
    }

    public function eliminarProducto(CarritoItem $item)
    {
        foreach($this->items as $key => $searchItem) {
            if($searchItem->getProducto()->pelicula_id === $item->getProducto()->pelicula_id) {
                unset($this->items[$key]);
                // Reseteamos las claves del array, para evitar posibles huecos en la secuencia de números.
                $this->items = array_values($this->items);
                return;
            }
        }
    }

    public function incrementarCantidad($item)
    {
        $searchItem = $this->getItem($item->getProducto()->pelicula_id);
        if(!$searchItem) return;

        $searchItem->incrementarCantidad();
    }

    public function setCantidad($item, $cantidad)
    {
        $searchedItem = $this->getItem($item->getProducto()->pelicula_id);
        if(!$searchedItem) return;

        $searchedItem->setCantidad($cantidad);
    }

    public function getItem(int $id): ?CarritoItem
    {
        foreach($this->items as $item) {
            if($item->getProducto()->pelicula_id === $id) {
                return $item;
            }
        }
        return null;
    }

    /**
     * @return CarritoItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
