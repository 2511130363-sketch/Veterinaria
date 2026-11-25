@extends('layouts.app')
@section('title', 'Reporte mascotas')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Reporte de mascotas</h4>
    <div>
        <a href="{{ route('reportes.mascotas', ['export'=>'pdf']) }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('reportes.mascotas', ['export'=>'excel']) }}" class="btn btn-success btn-sm">Excel</a>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Nombre</th><th>Especie</th><th>Raza</th><th>Sexo</th><th>Propietario</th></tr></thead>
            <tbody>
            @foreach($mascotas as $m)
                <tr>
                    <td>{{ $m->id }}</td>
                    <td>{{ $m->nombre }}</td>
                    <td>{{ $m->especie }}</td>
                    <td>{{ $m->raza }}</td>
                    <td>{{ $m->sexo }}</td>
                    <td>{{ $m->cliente->nombre_completo ?? '-' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
