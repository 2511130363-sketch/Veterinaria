@extends('layouts.app')
@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Clientes</h4>
    <a href="{{ route('clientes.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nuevo cliente</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar por nombre, DNI, teléfono o correo">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th><th>DNI</th><th>Teléfono</th><th>Email</th><th>Mascotas</th><th>Estado</th><th></th>
                </tr>
            </thead>
            <tbody>
            @forelse($clientes as $c)
                <tr>
                    <td>{{ $c->nombre_completo }}</td>
                    <td>{{ $c->dni }}</td>
                    <td>{{ $c->telefono }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->mascotas_count ?? $c->mascotas->count() }}</td>
                    <td>@if($c->activo)<span class="badge bg-success">Activo</span>@else<span class="badge bg-secondary">Inactivo</span>@endif</td>
                    <td class="text-end">
                        <a href="{{ route('clientes.show', $c) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('clientes.edit', $c) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('clientes.destroy', $c) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar cliente?')">
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
<div class="mt-3">{{ $clientes->links() }}</div>
@endsection
