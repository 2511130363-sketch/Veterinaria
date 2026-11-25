@extends('layouts.app')
@section('title', 'Consulta')

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Consulta #{{ $consulta->id }}</h5>
        <p><strong>Fecha:</strong> {{ $consulta->fecha->format('d/m/Y') }}</p>
        <p><strong>Mascota:</strong> {{ $consulta->mascota->nombre ?? '-' }} ({{ $consulta->mascota->cliente->nombre_completo ?? '' }})</p>
        <p><strong>Veterinario:</strong> {{ $consulta->veterinario->nombre_completo ?? '-' }}</p>
        <p><strong>Peso:</strong> {{ $consulta->peso }} kg | <strong>Temp:</strong> {{ $consulta->temperatura }} °C</p>
        <hr>
        <p><strong>Síntomas:</strong><br>{{ $consulta->sintomas }}</p>
        <p><strong>Diagnóstico:</strong><br>{{ $consulta->diagnostico }}</p>
        <p><strong>Tratamiento:</strong><br>{{ $consulta->tratamiento }}</p>
        <p><strong>Observaciones:</strong><br>{{ $consulta->observaciones }}</p>

        @if($consulta->tratamientos->count())
            <hr>
            <h6>Tratamientos detallados</h6>
            <table class="table table-sm">
                <thead><tr><th>Nombre</th><th>Descripción</th><th>Dosis</th><th>Frecuencia</th><th>Duración</th></tr></thead>
                <tbody>
                @foreach($consulta->tratamientos as $t)
                    <tr>
                        <td>{{ $t->nombre }}</td>
                        <td>{{ $t->descripcion }}</td>
                        <td>{{ $t->dosis }}</td>
                        <td>{{ $t->frecuencia }}</td>
                        <td>{{ $t->duracion }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
        <a href="{{ route('consultas.edit', $consulta) }}" class="btn btn-warning btn-sm">Editar</a>
    </div>
</div>
@endsection
