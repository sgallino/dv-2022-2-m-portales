<?php

namespace App\Cart;


use App\Models\Pelicula;

class CarritoItem
{
    // A partir de php 8+, tenemos una funcionalidad que se llama "promoted properties".
    // Esto permite simplificar la definición de propiedades de la clase que deben/pueden recibir valores
    // en el constructor.
    // Normalmente, si una clase puede recibir valores en el constructor para asignarlo a sus propiedades,
    // necesitamos:
    // 1. Declarar las propiedades.
    // 2. Pedir los valores de las propiedades en el constructor, con variables cuyos nombres suelen ser
    //  exactamente los mismos que las propiedades.
    // 3. Asignar esos parámetros a sus propiedades.
    // Por ejemplo, la implementación que sigue:
//    private Pelicula $producto;
//    private int $cantidad;
//
//    public function __construct(Pelicula $producto, int $cantidad = 1)
//    {
//        $this->producto = $producto;
//        $this->cantidad = $cantidad;
//    }
    // En vez de hacer eso, podemos "declarar" las propiedades como parámetros del constructor, directamente.
    // Si esos parámetros están definidos con su modificador de visibilidad, php automáticamente
    // "promueve" o "asciende de caterogía" esos parámetros a propiedades.
    public function __construct(
        private Pelicula $producto,
        private int $cantidad = 1
    )
    {}

    public function incrementarCantidad(int $cantidad = 1)
    {
//        $this->setCantidad($this->getCantidad() + $cantidad);
        $this->cantidad += $cantidad;
    }

    public function decrementarCantidad(int $cantidad = 1)
    {
        $this->cantidad -= $cantidad;
    }

    public function getSubtotal(): int
    {
        return $this->producto->precio * $this->cantidad;
    }

    public function getProducto(): Pelicula
    {
        return $this->producto;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad)
    {
        $this->cantidad = $cantidad;
    }
}
