@extends('layouts.app')
@section('title', 'Reporte ventas')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Reporte de ventas</h4>
    <div>
        <a href="{{ route('reportes.ventas', array_merge(request()->all(), ['export'=>'pdf'])) }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('reportes.ventas', array_merge(request()->all(), ['export'=>'excel'])) }}" class="btn btn-success btn-sm">Excel</a>
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
            <thead><tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Total</th><th>Método</th><th>Estado</th></tr></thead>
            <tbody>
            @foreach($ventas as $v)
                <tr>
                    <td>{{ $v->id }}</td>
                    <td>{{ $v->fecha->format('d/m/Y') }}</td>
                    <td>{{ $v->cliente->nombre_completo ?? 'Consumidor final' }}</td>
                    <td>S/ {{ number_format($v->total, 2) }}</td>
                    <td>{{ $v->metodo_pago }}</td>
                    <td>{{ $v->estado }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
