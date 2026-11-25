@extends('layouts.app')
@section('title', 'Veterinarios')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Veterinarios</h4>
    <a href="{{ route('veterinarios.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nuevo veterinario</a>
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
            <thead class="table-light"><tr><th>Nombre</th><th>Especialidad</th><th>Colegiatura</th><th>Teléfono</th><th>Email</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            @forelse($veterinarios as $v)
                <tr>
                    <td>{{ $v->nombre_completo }}</td>
                    <td>{{ $v->especialidad }}</td>
                    <td>{{ $v->colegiatura }}</td>
                    <td>{{ $v->telefono }}</td>
                    <td>{{ $v->email }}</td>
                    <td>@if($v->activo)<span class="badge bg-success">Activo</span>@else<span class="badge bg-secondary">Inactivo</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('veterinarios.show', $v) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('veterinarios.edit', $v) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('veterinarios.destroy', $v) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted">Sin registros</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $veterinarios->links() }}</div>
@endsection
