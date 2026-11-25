@extends('layouts.app')
@section('title', 'Servicios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Servicios</h4>
    <a href="{{ route('servicios.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nuevo servicio</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Nombre</th><th>Categoría</th><th>Precio</th><th>Duración</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            @forelse($servicios as $s)
                <tr>
                    <td>{{ $s->nombre }}</td>
                    <td>{{ $s->categoria->nombre ?? '-' }}</td>
                    <td>S/ {{ number_format($s->precio, 2) }}</td>
                    <td>{{ $s->duracion_minutos }} min</td>
                    <td>@if($s->activo)<span class="badge bg-success">Activo</span>@else<span class="badge bg-secondary">Inactivo</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('servicios.edit', $s) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('servicios.destroy', $s) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Sin registros</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $servicios->links() }}</div>
@endsection
