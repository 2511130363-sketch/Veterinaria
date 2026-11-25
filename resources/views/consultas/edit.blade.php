@extends('layouts.app')
@section('title', 'Editar consulta')

@section('content')
<div class="card">
    <div class="card-header">Editar consulta médica</div>
    <div class="card-body">
        <form method="POST" action="{{ route('consultas.update', $consulta) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Mascota</label>
                    <select name="mascota_id" class="form-select" required>
                        @foreach($mascotas as $m)
                            <option value="{{ $m->id }}" {{ old('mascota_id', $consulta->mascota_id)==$m->id?'selected':'' }}>{{ $m->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Veterinario</label>
                    <select name="veterinario_id" class="form-select" required>
                        @foreach($veterinarios as $v)
                            <option value="{{ $v->id }}" {{ old('veterinario_id', $consulta->veterinario_id)==$v->id?'selected':'' }}>{{ $v->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $consulta->fecha->format('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" class="form-control" value="{{ old('peso', $consulta->peso) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Temperatura (°C)</label>
                    <input type="number" step="0.01" name="temperatura" class="form-control" value="{{ old('temperatura', $consulta->temperatura) }}">
                </div>
                <div class="col-12">
                    <label class="form-label">Síntomas</label>
                    <textarea name="sintomas" class="form-control" rows="2">{{ old('sintomas', $consulta->sintomas) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Diagnóstico</label>
                    <textarea name="diagnostico" class="form-control" rows="2">{{ old('diagnostico', $consulta->diagnostico) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Tratamiento</label>
                    <textarea name="tratamiento" class="form-control" rows="2">{{ old('tratamiento', $consulta->tratamiento) }}</textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="2">{{ old('observaciones', $consulta->observaciones) }}</textarea>
                </div>
            </div>

            <hr>
            <h6>Tratamientos detallados</h6>
            <div id="tratamientos-container">
                @foreach($consulta->tratamientos as $t)
                    <div class="row g-2 mb-2 border rounded p-2">
                        <div class="col-md-3"><input type="text" name="trat_nombre[]" class="form-control" placeholder="Nombre" value="{{ $t->nombre }}"></div>
                        <div class="col-md-3"><input type="text" name="trat_descripcion[]" class="form-control" placeholder="Descripción" value="{{ $t->descripcion }}"></div>
                        <div class="col-md-2"><input type="text" name="trat_dosis[]" class="form-control" placeholder="Dosis" value="{{ $t->dosis }}"></div>
                        <div class="col-md-2"><input type="text" name="trat_frecuencia[]" class="form-control" placeholder="Frecuencia" value="{{ $t->frecuencia }}"></div>
                        <div class="col-md-2"><input type="text" name="trat_duracion[]" class="form-control" placeholder="Duración" value="{{ $t->duracion }}"></div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="addTratamiento()">Agregar tratamiento</button>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('consultas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
function addTratamiento() {
    const container = document.getElementById('tratamientos-container');
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
