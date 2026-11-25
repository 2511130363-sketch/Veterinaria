@extends('layouts.app')
@section('title', 'Reportes')

@section('content')
<h4>Reportes</h4>
<div class="row g-3">
    @php
        $items = [
            ['Reporte de clientes', 'reportes.clientes'],
            ['Reporte de mascotas', 'reportes.mascotas'],
            ['Reporte de citas', 'reportes.citas'],
            ['Reporte de consultas', 'reportes.consultas'],
            ['Servicios más solicitados', 'reportes.servicios'],
            ['Reporte de ventas', 'reportes.ventas'],
            ['Ingresos por fechas', 'reportes.ingresos'],
        ];
    @endphp
    @foreach($items as [$label, $route])
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6>{{ $label }}</h6>
                    <a href="{{ route($route) }}" class="btn btn-sm btn-primary">Ver reporte</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
