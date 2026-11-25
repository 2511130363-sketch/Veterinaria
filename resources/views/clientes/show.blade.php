@extends('layouts.app')
@section('title', 'Cliente')

@section('content')
<div class="row g-3">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Datos del cliente</div>
            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $cliente->nombre_completo }}</p>
                <p><strong>DNI:</strong> {{ $cliente->dni }}</p>
                <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                <p><strong>Email:</strong> {{ $cliente->email }}</p>
                <p><strong>Dirección:</strong> {{ $cliente->direccion }}</p>
                <a href="{{ route('clientes.edit', $cliente) }}" class="btn btn-warning btn-sm">Editar</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Mascotas asociadas</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Nombre</th><th>Especie</th><th>Raza</th><th></th></tr></thead>
                    <tbody>
                    @forelse($cliente->mascotas as $m)
                        <tr>
                            <td>{{ $m->nombre }}</td>
                            <td>{{ $m->especie }}</td>
                            <td>{{ $m->raza }}</td>
                            <td><a href="{{ route('mascotas.show', $m) }}" class="btn btn-sm btn-outline-info">Ver</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Sin mascotas</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-header">Historial de ventas</div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead><tr><th>Fecha</th><th>Total</th><th>Método</th></tr></thead>
                    <tbody>
                    @forelse($cliente->ventas as $v)
                        <tr>
                            <td>{{ $v->fecha->format('d/m/Y') }}</td>
                            <td>S/ {{ number_format($v->total, 2) }}</td>
                            <td>{{ $v->metodo_pago }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">Sin ventas</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
