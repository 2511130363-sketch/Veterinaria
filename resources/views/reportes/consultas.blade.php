@extends('layouts.app')
@section('title', 'Reporte consultas')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Reporte de consultas</h4>
    <div>
        <a href="{{ route('reportes.consultas', array_merge(request()->all(), ['export'=>'pdf'])) }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('reportes.consultas', array_merge(request()->all(), ['export'=>'excel'])) }}" class="btn btn-success btn-sm">Excel</a>
    </div>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4"><input type="date" name="desde" value="{{ $desde }}" class="form-control"></div>
    <div class="col-md-4"><input type="date" name="hasta" value="{{ $hasta }}" class="form-control"></div>
    <div class="col-md-4"><button class="btn btn-outline-secondary w-100" type="submit">Filtrar</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Fecha</th><th>Mascota</th><th>Propietario</th><th>Veterinario</th><th>Diagnóstico</th></tr></thead>
            <tbody>
            @foreach($consultas as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->fecha->format('d/m/Y') }}</td>
                    <td>{{ $c->mascota->nombre ?? '-' }}</td>
                    <td>{{ $c->mascota->cliente->nombre_completo ?? '-' }}</td>
                    <td>{{ $c->veterinario->nombre_completo ?? '-' }}</td>
                    <td>{{ Str::limit($c->diagnostico, 50) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
