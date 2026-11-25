@extends('layouts.app')
@section('title', 'Reporte citas')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Reporte de citas</h4>
    <div>
        <a href="{{ route('reportes.citas', array_merge(request()->all(), ['export'=>'pdf'])) }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('reportes.citas', array_merge(request()->all(), ['export'=>'excel'])) }}" class="btn btn-success btn-sm">Excel</a>
    </div>
</div>

<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3"><input type="date" name="desde" value="{{ $desde }}" class="form-control"></div>
    <div class="col-md-3"><input type="date" name="hasta" value="{{ $hasta }}" class="form-control"></div>
    <div class="col-md-3">
        <select name="estado" class="form-select">
            <option value="">Estado</option>
            @foreach(['pendiente','confirmada','atendida','cancelada'] as $e)
                <option value="{{ $e }}" {{ $estado==$e?'selected':'' }}>{{ $e }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3"><button class="btn btn-outline-secondary w-100" type="submit">Filtrar</button></div>
</form>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Mascota</th><th>Veterinario</th><th>Estado</th></tr></thead>
            <tbody>
            @foreach($citas as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->fecha->format('d/m/Y') }}</td>
                    <td>{{ $c->hora }}</td>
                    <td>{{ $c->cliente->nombre_completo ?? '-' }}</td>
                    <td>{{ $c->mascota->nombre ?? '-' }}</td>
                    <td>{{ $c->veterinario->nombre_completo ?? '-' }}</td>
                    <td>{{ $c->estado }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
