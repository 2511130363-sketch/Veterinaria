@extends('layouts.app')
@section('title', 'Mascotas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Mascotas</h4>
    <a href="{{ route('mascotas.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Nueva mascota</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Buscar por nombre, especie, raza o propietario">
        <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
    </div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr><th>Foto</th><th>Nombre</th><th>Especie</th><th>Raza</th><th>Sexo</th><th>Propietario</th><th></th></tr>
            </thead>
            <tbody>
            @forelse($mascotas as $m)
                <tr>
                    <td>
                        @if($m->foto)
                            <img src="{{ asset('storage/'.$m->foto) }}" alt="" width="40" height="40" class="rounded-circle" style="object-fit:cover">
                        @else
                            <i class="bi bi-emoji-smile fs-4"></i>
                        @endif
                    </td>
                    <td>{{ $m->nombre }}</td>
                    <td>{{ $m->especie }}</td>
                    <td>{{ $m->raza }}</td>
                    <td>{{ $m->sexo }}</td>
                    <td>{{ $m->cliente->nombre_completo ?? '-' }}</td>
                    <td class="text-end">
                        <a href="{{ route('mascotas.show', $m) }}" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('mascotas.edit', $m) }}" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('mascotas.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar mascota?')">
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
<div class="mt-3">{{ $mascotas->links() }}</div>
@endsection
