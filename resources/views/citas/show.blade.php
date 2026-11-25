@extends('layouts.app')
@section('title', 'Cita')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Cita #{{ $cita->id }}</h5>
        <p><strong>Fecha:</strong> {{ $cita->fecha->format('d/m/Y') }} {{ $cita->hora }}</p>
        <p><strong>Cliente:</strong> {{ $cita->cliente->nombre_completo ?? '-' }}</p>
        <p><strong>Mascota:</strong> {{ $cita->mascota->nombre ?? '-' }}</p>
        <p><strong>Veterinario:</strong> {{ $cita->veterinario->nombre_completo ?? '-' }}</p>
        <p><strong>Estado:</strong> {{ $cita->estado }}</p>
        <p><strong>Motivo:</strong> {{ $cita->motivo }}</p>
        <a href="{{ route('citas.edit', $cita) }}" class="btn btn-warning btn-sm">Editar</a>
        @if(!$cita->consulta)
            <a href="{{ route('consultas.create', ['cita_id' => $cita->id]) }}" class="btn btn-primary btn-sm">Registrar consulta</a>
        @else
            <a href="{{ route('consultas.show', $cita->consulta) }}" class="btn btn-info btn-sm">Ver consulta</a>
        @endif
    </div>
</div>
@endsection
