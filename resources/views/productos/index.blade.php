@extends('layouts.app')
@section('title', 'Productos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Productos</h4>
    <a href="{{ route('productos.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nuevo producto</a>
</div>

@if($stockBajo > 0)
    <div class="alert alert-warning">Hay {{ $stockBajo }} producto(s) con stock bajo.</div>
@endif

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Nombre</th><th>Categoría</th><th>P.Compra</th><th>P.Venta</th><th>Stock</th><th>Mínimo</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            @forelse($productos as $p)
                <tr class="{{ $p->stockBajo() ? 'table-warning' : '' }}">
                    <td>{{ $p->nombre }}</td>
                    <td>{{ $p->categoria->nombre ?? '-' }}</td>
                    <td>S/ {{ number_format($p->precio_compra, 2) }}</td>
                    <td>S/ {{ number_format($p->precio_venta, 2) }}</td>
                    <td>{{ $p->stock }}</td>
                    <td>{{ $p->stock_minimo }}</td>
                    <td>@if($p->activo)<span class="badge bg-success">Activo</span>@else<span class="badge bg-secondary">Inactivo</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('productos.show', $p) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('productos.edit', $p) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('productos.destroy', $p) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">Sin registros</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $productos->links() }}</div>
@endsection
