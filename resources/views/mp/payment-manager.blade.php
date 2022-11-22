<?php
/** @var \App\MercadoPago\PaymentManager $payment */
?>
@extends('layouts.main')

@section('title', 'Confirmar Compra')

{{-- Pusheamos los scripts al stack de 'js' --}}
@push('js')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('{{ $payment->getPublicKey() }}', {
            locale: 'es-AR',
        });

        mp.checkout({
            preference: {
                id: '{{ $payment->getPaymentId() }}'
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
        @foreach($payment->getItems() as $item)
        <tr>
            <td>{{ $item->getTitle() }}</td>
            <td>$ {{ $item->getUnitPrice() }}</td>
            <td>{{ $item->getQuantity() }}</td>
            <td>$ {{ $item->getSubtotal() }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3"><b>TOTAL:</b></td>
            <td><b>$ {{ $payment->getTotal() }}</b></td>
        </tr>
        </tbody>
    </table>

    <div class="checkout"></div>
@endsection
