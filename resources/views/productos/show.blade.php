@extends('layouts.app')
@section('title', 'Producto')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>{{ $producto->nombre }}</h5>
        <p><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? '-' }}</p>
        <p><strong>Descripción:</strong> {{ $producto->descripcion }}</p>
        <p><strong>P. compra:</strong> S/ {{ number_format($producto->precio_compra, 2) }}</p>
        <p><strong>P. venta:</strong> S/ {{ number_format($producto->precio_venta, 2) }}</p>
        <p><strong>Stock:</strong> {{ $producto->stock }} (mínimo {{ $producto->stock_minimo }})</p>
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>
</div>

<div class="card mt-3">
    <div class="card-header">Movimientos de inventario</div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead><tr><th>Fecha</th><th>Tipo</th><th>Cantidad</th><th>Motivo</th><th>Usuario</th></tr></thead>
            <tbody>
            @forelse($producto->movimientos as $m)
                <tr>
                    <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $m->tipo }}</td>
                    <td>{{ $m->cantidad }}</td>
                    <td>{{ $m->motivo }}</td>
                    <td>{{ $m->user->name ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Sin movimientos</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
