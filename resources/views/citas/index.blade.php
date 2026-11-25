@extends('layouts.app')
@section('title', 'Citas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Citas</h4>
    <a href="{{ route('citas.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nueva cita</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <input type="date" name="fecha" value="{{ $fecha }}" class="form-control">
    </div>
    <div class="col-md-3">
        <select name="veterinario_id" class="form-select">
            <option value="">Veterinario</option>
            @foreach($veterinarios as $v)
                <option value="{{ $v->id }}" {{ $veterinario_id==$v->id?'selected':'' }}>{{ $v->nombre_completo }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="estado" class="form-select">
            <option value="">Estado</option>
            @foreach(['pendiente','confirmada','atendida','cancelada'] as $e)
                <option value="{{ $e }}" {{ $estado==$e?'selected':'' }}>{{ $e }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <button class="btn btn-outline-secondary w-100" type="submit"><i class="bi bi-funnel"></i> Filtrar</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Mascota</th><th>Veterinario</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            @forelse($citas as $c)
                <tr>
                    <td>{{ $c->fecha->format('d/m/Y') }}</td>
                    <td>{{ $c->hora }}</td>
                    <td>{{ $c->cliente->nombre_completo ?? '-' }}</td>
                    <td>{{ $c->mascota->nombre ?? '-' }}</td>
                    <td>{{ $c->veterinario->nombre_completo ?? '-' }}</td>
                    <td>
                        <span class="badge bg-{{ $c->estado=='atendida'?'success':($c->estado=='cancelada'?'danger':($c->estado=='confirmada'?'primary':'secondary')) }}">{{ $c->estado }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('citas.show', $c) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('citas.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('citas.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted">Sin citas</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $citas->links() }}</div>
@endsection
