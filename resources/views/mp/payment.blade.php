<?php
/** @var \MercadoPago\Preference $preference */
/** @var string $publicKey */
?>
@extends('layouts.main')

@section('title', 'Confirmar Compra')

{{-- Pusheamos los scripts al stack de 'js' --}}
@push('js')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('{{ $publicKey }}', {
            locale: 'es-AR',
        });

        mp.checkout({
            preference: {
                id: '{{ $preference->id }}'
            },
            render: {
                container: '.checkout'
            }
        });
    </script>
@endpush

@section('main')
    <h1 class="mb-3">Confirmar Detalle de Compra</h1>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>Título</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @foreach($preference->items as $item)
        <tr>
            <td>{{ $item->title }}</td>
            <td>$ {{ $item->unit_price }}</td>
            <td>{{ $item->quantity }}</td>
            <td>$ {{ $item->unit_price * $item->quantity }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <div class="checkout"></div>
@endsection
