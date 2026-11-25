@extends('layouts.app')
@section('title', 'Editar cita')

@section('content')
<div class="card">
    <div class="card-header">Editar cita</div>
    <div class="card-body">
        <form method="POST" action="{{ route('citas.update', $cita) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select" required>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ old('cliente_id', $cita->cliente_id)==$c->id?'selected':'' }}>{{ $c->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mascota</label>
                    <select name="mascota_id" class="form-select" required>
                        @foreach($mascotas as $m)
                            <option value="{{ $m->id }}" {{ old('mascota_id', $cita->mascota_id)==$m->id?'selected':'' }}>{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Veterinario</label>
                    <select name="veterinario_id" class="form-select" required>
                        @foreach($veterinarios as $v)
                            <option value="{{ $v->id }}" {{ old('veterinario_id', $cita->veterinario_id)==$v->id?'selected':'' }}>{{ $v->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $cita->fecha->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-control" value="{{ old('hora', $cita->hora) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        @foreach(['pendiente','confirmada','atendida','cancelada'] as $e)
                            <option value="{{ $e }}" {{ old('estado', $cita->estado)==$e?'selected':'' }}>{{ $e }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Motivo</label>
                    <textarea name="motivo" class="form-control" rows="2">{{ old('motivo', $cita->motivo) }}</textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
