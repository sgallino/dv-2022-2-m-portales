<?php

namespace App\MercadoPago;


use App\Models\Pelicula;
use Illuminate\Database\Eloquent\Collection;
use MercadoPago\Preference;
use MercadoPago\SDK;

class PaymentManager
{
    private Preference $preference;
    /** @var PaymentItem[] */
    private array $items = [];

    public function __construct()
    {
        SDK::setAccessToken(config('mercadopago.access_token'));
        $this->preference = new Preference();
    }

    /**
     * @param Collection|Pelicula[] $items
     * @return $this
     */
    public function setItems(Collection $items): self
    {
        $prefItems = [];

        /** @var Pelicula $item */
        foreach($items as $item) {
            $paymentItem = new PaymentItem(
                title: $item->titulo,
                unit_price: $item->precio,
                quantity: 1,
                id: $item->pelicula_id,
            );
            $this->items[] = $paymentItem;

            $prefItems[] = $paymentItem->getMPItem();
        }

        $this->preference->items = $prefItems;

        return $this;
    }

    /**
     * Define las URLs de retorno del pago.
     * Aceptan 3 posibles claves:
     * 'success', 'pending', 'failure'.
     *
     * @param string|null $success
     * @param string|null $pending
     * @param string|null $failure
     * @return $this
     */
    public function setBackUrls(?string $success = null, ?string $pending = null, ?string $failure = null): self
    {
        $this->preference->back_urls = [
            'success' => $success,
            'pending' => $pending,
            'failure' => $failure,
        ];

        return $this;
    }

    /**
     * Prepara la preferencia para su cobro.
     *
     * @return void
     * @throws \Exception
     */
    public function save()
    {
        $this->preference->save();
    }

    public function getTotal(): float
    {
        $total = 0;

        foreach($this->getItems() as $item) {
            $total += $item->getSubtotal();
        }

        return $total;
    }

    /**
     * @return string
     */
    public function getPublicKey(): string
    {
        return config('mercadopago.public_key');
    }

    /**
     * @return PaymentItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPaymentId(): string
    {
        return $this->preference->id;
    }
}
