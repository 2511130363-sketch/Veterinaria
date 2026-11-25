@extends('layouts.app')
@section('title', 'Editar mascota')

@section('content')
<div class="card">
    <div class="card-header">Editar mascota</div>
    <div class="card-body">
        <form method="POST" action="{{ route('mascotas.update', $mascota) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Propietario</label>
                    <select name="cliente_id" class="form-select" required>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}" {{ old('cliente_id', $mascota->cliente_id) == $c->id ? 'selected' : '' }}>{{ $c->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $mascota->nombre) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Especie</label>
                    <input type="text" name="especie" class="form-control" value="{{ old('especie', $mascota->especie) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Raza</label>
                    <input type="text" name="raza" class="form-control" value="{{ old('raza', $mascota->raza) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sexo</label>
                    <select name="sexo" class="form-select" required>
                        <option value="macho" {{ old('sexo', $mascota->sexo)=='macho'?'selected':'' }}>Macho</option>
                        <option value="hembra" {{ old('sexo', $mascota->sexo)=='hembra'?'selected':'' }}>Hembra</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', optional($mascota->fecha_nacimiento)->format('Y-m-d')) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" class="form-control" value="{{ old('peso', $mascota->peso) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Color</label>
                    <input type="text" name="color" class="form-control" value="{{ old('color', $mascota->color) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fotografía</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    @if($mascota->foto)
                        <img src="{{ asset('storage/'.$mascota->foto) }}" class="mt-2 rounded" width="80">
                    @endif
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $mascota->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('mascotas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
