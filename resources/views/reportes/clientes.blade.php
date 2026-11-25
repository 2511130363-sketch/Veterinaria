@extends('layouts.app')
@section('title', 'Reporte clientes')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Reporte de clientes</h4>
    <div>
        <a href="{{ route('reportes.clientes', ['export'=>'pdf']) }}" class="btn btn-danger btn-sm">PDF</a>
        <a href="{{ route('reportes.clientes', ['export'=>'excel']) }}" class="btn btn-success btn-sm">Excel</a>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>ID</th><th>Nombre</th><th>DNI</th><th>Teléfono</th><th>Email</th><th>Mascotas</th></tr></thead>
            <tbody>
            @foreach($clientes as $c)
                <tr>
                    <td>{{ $c->id }}</td>
                    <td>{{ $c->nombre_completo }}</td>
                    <td>{{ $c->dni }}</td>
                    <td>{{ $c->telefono }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->mascotas_count }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
