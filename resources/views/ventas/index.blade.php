@extends('layouts.app')
@section('title', 'Ventas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Ventas</h4>
    <a href="{{ route('ventas.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nueva venta</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="date" name="desde" value="{{ $desde }}" class="form-control" placeholder="Desde">
    </div>
    <div class="col-md-4">
        <input type="date" name="hasta" value="{{ $hasta }}" class="form-control" placeholder="Hasta">
    </div>
    <div class="col-md-4">
        <button class="btn btn-outline-secondary w-100" type="submit"><i class="bi bi-funnel"></i> Filtrar</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>#</th><th>Fecha</th><th>Cliente</th><th>Total</th><th>Método</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            @forelse($ventas as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->fecha->format('d/m/Y') }}</td>
                    <td>{{ $v->cliente->nombre_completo ?? 'Consumidor final' }}</td>
                    <td>S/ {{ number_format($v->total, 2) }}</td>
                    <td>{{ $v->metodo_pago }}</td>
                    <td><span class="badge bg-{{ $v->estado=='anulada'?'danger':'success' }}">{{ $v->estado }}</span></td>
                    <td class="text-end">
                        <a href="{{ route('ventas.show', $v) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        @if($v->estado !== 'anulada')
                            <form action="{{ route('ventas.destroy', $v) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Anular venta?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger"><i class="bi bi-x-circle"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted">Sin ventas</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $ventas->links() }}</div>
@endsection
