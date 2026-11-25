@extends('layouts.app')
@section('title', 'Inventario')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Movimientos de inventario</h4>
    <a href="{{ route('inventario.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nuevo movimiento</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Fecha</th><th>Producto</th><th>Tipo</th><th>Cantidad</th><th>Motivo</th><th>Usuario</th></tr></thead>
            <tbody>
            @forelse($movimientos as $m)
                <tr>
                    <td>{{ $m->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $m->producto->nombre ?? '-' }}</td>
                    <td><span class="badge {{ $m->tipo=='entrada'?'bg-success':'bg-warning' }}">{{ $m->tipo }}</span></td>
                    <td>{{ $m->cantidad }}</td>
                    <td>{{ $m->motivo }}</td>
                    <td>{{ $m->user->name ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Sin movimientos</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $movimientos->links() }}</div>
@endsection
