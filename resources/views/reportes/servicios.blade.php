@extends('layouts.app')
@section('title', 'Reporte servicios')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Servicios más solicitados</h4>
    <div>
        <a href="{{ route('reportes.servicios', ['export'=>'pdf']) }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('reportes.servicios', ['export'=>'excel']) }}" class="btn btn-success btn-sm">Excel</a>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>Servicio</th><th>Cantidad</th><th>Monto</th></tr></thead>
            <tbody>
            @foreach($servicios as $s)
                <tr>
                    <td>{{ $s->servicio->nombre ?? '-' }}</td>
                    <td>{{ $s->total }}</td>
                    <td>S/ {{ number_format($s->monto, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
