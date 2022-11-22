<?php

namespace App\MercadoPago;


use MercadoPago\Item;

class PaymentItem
{
//    private ?string $id;
//    private string $title;
//    private float $unit_price;
//    private int $quantity;

//    public function __construct(string $title, float $unit_price, int $quantity, ?string $id = null)
//    {
//        $this->title = $title;
//        $this->unit_price = $unit_price;
//        $this->quantity = $quantity;
//        $this->id = $id;
//    }

    // Usando "property promotion" (php 8+)
    public function __construct(
        private string $title,
        private float $unit_price,
        private int $quantity,
        private ?string $id = null,
        private ?string $currency_id = null,
        private ?string $category_id = null,
    )
    {}

    public function getMPItem(): Item
    {
        $item = new Item();
        $item->id = $this->id;
        $item->title = $this->title;
        $item->unit_price = $this->unit_price;
        $item->quantity = 1;
        $item->currency_id = $this->currency_id;
        $item->category_id = $this->category_id;

        return $item;
    }

    public function getSubtotal(): float
    {
        return $this->getUnitPrice() * $this->getQuantity();
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getUnitPrice(): float
    {
        return $this->unit_price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getCurrencyId(): ?string
    {
        return $this->currency_id;
    }

    /**
     * @return string|null
     */
    public function getCategoryId(): ?string
    {
        return $this->category_id;
    }
}
