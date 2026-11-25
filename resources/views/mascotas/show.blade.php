@extends('layouts.app')
@section('title', 'Mascota')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                @if($mascota->foto)
                    <img src="{{ asset('storage/'.$mascota->foto) }}" class="rounded-circle mb-3" width="120" height="120" style="object-fit:cover">
                @else
                    <i class="bi bi-emoji-smile fs-1"></i>
                @endif
                <h5>{{ $mascota->nombre }}</h5>
                <p class="text-muted">{{ $mascota->especie }} - {{ $mascota->raza }}</p>
                <p><strong>Propietario:</strong> <a href="{{ route('clientes.show', $mascota->cliente) }}">{{ $mascota->cliente->nombre_completo ?? '-' }}</a></p>
                <p><strong>Sexo:</strong> {{ $mascota->sexo }}</p>
                <p><strong>Nacimiento:</strong> {{ optional($mascota->fecha_nacimiento)->format('d/m/Y') }}</p>
                <p><strong>Peso:</strong> {{ $mascota->peso }} kg</p>
                <p><strong>Color:</strong> {{ $mascota->color }}</p>
                <a href="{{ route('mascotas.edit', $mascota) }}" class="btn btn-warning btn-sm">Editar</a>
                <a href="{{ route('consultas.create', ['mascota_id' => $mascota->id]) }}" class="btn btn-primary btn-sm">Nueva consulta</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Historial clínico</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Fecha</th><th>Veterinario</th><th>Diagnóstico</th><th></th></tr></thead>
                    <tbody>
                    @forelse($mascota->consultas as $c)
                        <tr>
                            <td>{{ $c->fecha->format('d/m/Y') }}</td>
                            <td>{{ $c->veterinario->nombre_completo ?? '-' }}</td>
                            <td>{{ Str::limit($c->diagnostico, 60) }}</td>
                            <td><a href="{{ route('consultas.show', $c) }}" class="btn btn-sm btn-outline-info">Ver</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin consultas</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">Citas</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Fecha</th><th>Hora</th><th>Veterinario</th><th>Estado</th></tr></thead>
                    <tbody>
                    @forelse($mascota->citas as $c)
                        <tr>
                            <td>{{ $c->fecha->format('d/m/Y') }}</td>
                            <td>{{ $c->hora }}</td>
                            <td>{{ $c->veterinario->nombre_completo ?? '-' }}</td>
                            <td>{{ $c->estado }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin citas</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
