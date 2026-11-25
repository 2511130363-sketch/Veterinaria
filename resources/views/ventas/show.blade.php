@extends('layouts.app')
@section('title', 'Venta')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Venta #{{ $venta->id }}</h5>
        <p><strong>Fecha:</strong> {{ $venta->fecha->format('d/m/Y') }}</p>
        <p><strong>Cliente:</strong> {{ $venta->cliente->nombre_completo ?? 'Consumidor final' }}</p>
        <p><strong>Método:</strong> {{ $venta->metodo_pago }}</p>
        <p><strong>Estado:</strong> {{ $venta->estado }}</p>

        <table class="table">
            <thead><tr><th>Concepto</th><th>Cantidad</th><th>P. Unitario</th><th>Subtotal</th></tr></thead>
            <tbody>
            @foreach($venta->detalles as $d)
                <tr>
                    <td>{{ $d->descripcion }}</td>
                    <td>{{ $d->cantidad }}</td>
                    <td>S/ {{ number_format($d->precio_unitario, 2) }}</td>
                    <td>S/ {{ number_format($d->subtotal, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr><th colspan="3" class="text-end">Total</th><th>S/ {{ number_format($venta->total, 2) }}</th></tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
