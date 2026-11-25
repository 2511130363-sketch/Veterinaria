@extends('layouts.app')
@section('title', 'Ingresos')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Ingresos por fechas</h4>
    <div>
        <a href="{{ route('reportes.ingresos', array_merge(request()->all(), ['export'=>'pdf'])) }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('reportes.ingresos', array_merge(request()->all(), ['export'=>'excel'])) }}" class="btn btn-success btn-sm">Excel</a>
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
            <thead><tr><th>Fecha</th><th>Ventas</th><th>Total</th></tr></thead>
            <tbody>
            @foreach($ingresos as $i)
                <tr>
                    <td>{{ $i->fecha }}</td>
                    <td>{{ $i->ventas }}</td>
                    <td>S/ {{ number_format($i->total, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot><tr><th>Total</th><th></th><th>S/ {{ number_format($totalGeneral, 2) }}</th></tr></tfoot>
        </table>
    </div>
</div>
@endsection
