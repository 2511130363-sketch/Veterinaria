@extends('layouts.app')
@section('title', 'Nueva consulta')

@section('content')
<div class="card">
    <div class="card-header">Registrar consulta médica</div>
    <div class="card-body">
        <form method="POST" action="{{ route('consultas.store') }}">
            @csrf
            @if($cita)
                <input type="hidden" name="cita_id" value="{{ $cita->id }}">
            @endif
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Mascota</label>
                    <select name="mascota_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($mascotas as $m)
                            <option value="{{ $m->id }}" {{ old('mascota_id', request('mascota_id', $cita?->mascota_id))==$m->id?'selected':'' }}>{{ $m->nombre }} ({{ $m->cliente->nombre_completo ?? '' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Veterinario</label>
                    <select name="veterinario_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($veterinarios as $v)
                            <option value="{{ $v->id }}" {{ old('veterinario_id', $cita?->veterinario_id)==$v->id?'selected':'' }}>{{ $v->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', now()->toDateString()) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" class="form-control" value="{{ old('peso') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Temperatura (°C)</label>
                    <input type="number" step="0.01" name="temperatura" class="form-control" value="{{ old('temperatura') }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Síntomas</label>
                    <textarea name="sintomas" class="form-control" rows="2">{{ old('sintomas') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Diagnóstico</label>
                    <textarea name="diagnostico" class="form-control" rows="2">{{ old('diagnostico') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Tratamiento</label>
                    <textarea name="tratamiento" class="form-control" rows="2">{{ old('tratamiento') }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones') }}</textarea>
                </div>
            </div>

            <hr>
            <h6>Tratamientos detallados</h6>
            <div id="tratamientos-container"></div>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="addTratamiento()">Agregar tratamiento</button>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('consultas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
function addTratamiento() {
    const container = document.getElementById('tratamientos-container');
    const idx = container.children.length;
    const html = `
    <div class="row g-2 mb-2 border rounded p-2">
        <div class="col-md-3"><input type="text" name="trat_nombre[]" class="form-control" placeholder="Nombre"></div>
        <div class="col-md-3"><input type="text" name="trat_descripcion[]" class="form-control" placeholder="Descripción"></div>
        <div class="col-md-2"><input type="text" name="trat_dosis[]" class="form-control" placeholder="Dosis"></div>
        <div class="col-md-2"><input type="text" name="trat_frecuencia[]" class="form-control" placeholder="Frecuencia"></div>
        <div class="col-md-2"><input type="text" name="trat_duracion[]" class="form-control" placeholder="Duración"></div>
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
}
</script>
@endsection
