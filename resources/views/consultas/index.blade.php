@extends('layouts.app')
@section('title', 'Consultas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Consultas</h4>
    <a href="{{ route('consultas.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nueva consulta</a>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <select name="mascota_id" class="form-select">
            <option value="">Mascota</option>
            @foreach($mascotas as $m)
                <option value="{{ $m->id }}" {{ $mascota_id==$m->id?'selected':'' }}>{{ $m->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <select name="veterinario_id" class="form-select">
            <option value="">Veterinario</option>
            @foreach($veterinarios as $v)
                <option value="{{ $v->id }}" {{ $veterinario_id==$v->id?'selected':'' }}>{{ $v->nombre_completo }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <button class="btn btn-outline-secondary w-100" type="submit"><i class="bi bi-funnel"></i> Filtrar</button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Fecha</th><th>Mascota</th><th>Propietario</th><th>Veterinario</th><th>Diagnóstico</th><th></th></tr></thead>
            <tbody>
            @forelse($consultas as $c)
                <tr>
                    <td>{{ $c->fecha->format('d/m/Y') }}</td>
                    <td>{{ $c->mascota->nombre ?? '-' }}</td>
                    <td>{{ $c->mascota->cliente->nombre_completo ?? '-' }}</td>
                    <td>{{ $c->veterinario->nombre_completo ?? '-' }}</td>
                    <td>{{ Str::limit($c->diagnostico, 40) }}</td>
                    <td class="text-end">
                        <a href="{{ route('consultas.show', $c) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('consultas.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('consultas.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Sin consultas</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $consultas->links() }}</div>
@endsection
