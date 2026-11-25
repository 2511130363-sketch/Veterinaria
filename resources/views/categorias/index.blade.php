@extends('layouts.app')
@section('title', 'Categorías')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Categorías</h4>
    <a href="{{ route('categorias.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nueva categoría</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Nombre</th><th>Tipo</th><th>Descripción</th><th>Estado</th><th></th></tr></thead>
            <tbody>
            @forelse($categorias as $c)
                <tr>
                    <td>{{ $c->nombre }}</td>
                    <td>{{ $c->tipo }}</td>
                    <td>{{ $c->descripcion }}</td>
                    <td>@if($c->activo)<span class="badge bg-success">Activo</span>@else<span class="badge bg-secondary">Inactivo</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('categorias.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('categorias.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Sin registros</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $categorias->links() }}</div>
@endsection
