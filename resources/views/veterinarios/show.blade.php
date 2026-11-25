@extends('layouts.app')
@section('title', 'Veterinario')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>{{ $veterinario->nombre_completo }}</h5>
        <p><strong>Especialidad:</strong> {{ $veterinario->especialidad }}</p>
        <p><strong>Colegiatura:</strong> {{ $veterinario->colegiatura }}</p>
        <p><strong>Teléfono:</strong> {{ $veterinario->telefono }}</p>
        <p><strong>Email:</strong> {{ $veterinario->email }}</p>
        <p><strong>Estado:</strong> {{ $veterinario->activo ? 'Activo' : 'Inactivo' }}</p>
        <a href="{{ route('veterinarios.edit', $veterinario) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>
</div>
@endsection
