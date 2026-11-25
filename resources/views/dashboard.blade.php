@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon bg-primary-subtle text-primary"><i class="bi bi-emoji-smile"></i></div>
                <div>
                    <div class="text-muted small">Mascotas</div>
                    <div class="fs-4 fw-bold">{{ $totalMascotas }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon bg-success-subtle text-success"><i class="bi bi-people"></i></div>
                <div>
                    <div class="text-muted small">Clientes</div>
                    <div class="fs-4 fw-bold">{{ $totalClientes }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon bg-warning-subtle text-warning"><i class="bi bi-calendar-event"></i></div>
                <div>
                    <div class="text-muted small">Citas hoy</div>
                    <div class="fs-4 fw-bold">{{ $citasHoy }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon bg-info-subtle text-info"><i class="bi bi-file-medical"></i></div>
                <div>
                    <div class="text-muted small">Consultas</div>
                    <div class="fs-4 fw-bold">{{ $consultasRealizadas }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon bg-success-subtle text-success"><i class="bi bi-cash"></i></div>
                <div>
                    <div class="text-muted small">Ingresos hoy</div>
                    <div class="fs-4 fw-bold">S/ {{ number_format($ingresosHoy, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-stat">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="icon bg-primary-subtle text-primary"><i class="bi bi-graph-up"></i></div>
                <div>
                    <div class="text-muted small">Ingresos del mes</div>
                    <div class="fs-4 fw-bold">S/ {{ number_format($ingresosMes, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">Ingresos últimos 7 días</div>
            <div class="card-body">
                <canvas id="chartIngresos" height="120"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">Consultas últimos 6 meses</div>
            <div class="card-body">
                <canvas id="chartConsultas" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Últimas citas</span>
                <a href="{{ route('citas.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Fecha</th><th>Mascota</th><th>Veterinario</th><th>Estado</th></tr></thead>
                    <tbody>
                    @foreach($ultimasCitas as $c)
                        <tr>
                            <td>{{ $c->fecha->format('d/m/Y') }} {{ $c->hora }}</td>
                            <td>{{ $c->mascota->nombre ?? '-' }}</td>
                            <td>{{ $c->veterinario->nombre_completo ?? '-' }}</td>
                            <td><span class="badge bg-secondary">{{ $c->estado }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <span>Próximas citas</span>
                <a href="{{ route('citas.create') }}" class="btn btn-sm btn-primary">Nueva cita</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead><tr><th>Fecha</th><th>Mascota</th><th>Cliente</th><th>Estado</th></tr></thead>
                    <tbody>
                    @foreach($proximasCitas as $c)
                        <tr>
                            <td>{{ $c->fecha->format('d/m/Y') }} {{ $c->hora }}</td>
                            <td>{{ $c->mascota->nombre ?? '-' }}</td>
                            <td>{{ $c->cliente->nombre_completo ?? '-' }}</td>
                            <td><span class="badge bg-info">{{ $c->estado }}</span></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="mt-4 d-flex gap-2 flex-wrap">
    <a href="{{ route('clientes.create') }}" class="btn btn-outline-primary"><i class="bi bi-person-plus"></i> Nuevo cliente</a>
    <a href="{{ route('mascotas.create') }}" class="btn btn-outline-success"><i class="bi bi-emoji-smile"></i> Nueva mascota</a>
    <a href="{{ route('citas.create') }}" class="btn btn-outline-warning"><i class="bi bi-calendar-plus"></i> Nueva cita</a>
    <a href="{{ route('ventas.create') }}" class="btn btn-outline-info"><i class="bi bi-cart-plus"></i> Nueva venta</a>
    <a href="{{ route('consultas.create') }}" class="btn btn-outline-secondary"><i class="bi bi-file-medical"></i> Nueva consulta</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
const ingresosData = @json($ingresos7);
const consultasData = @json($consultas6);
new Chart(document.getElementById('chartIngresos'), {
    type: 'bar',
    data: {
        labels: ingresosData.map(d => d.fecha),
        datasets: [{ label: 'Ingresos', data: ingresosData.map(d => d.total), backgroundColor: '#1b7a6b' }]
    }
});
new Chart(document.getElementById('chartConsultas'), {
    type: 'line',
    data: {
        labels: consultasData.map(d => d.mes),
        datasets: [{ label: 'Consultas', data: consultasData.map(d => d.total), borderColor: '#f4a261', tension: .3, fill: false }]
    }
});
</script>
@endsection
