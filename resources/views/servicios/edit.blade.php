@extends('layouts.app')
@section('title', 'Editar servicio')

@section('content')
<div class="card">
    <div class="card-header">Editar servicio</div>
    <div class="card-body">
        <form method="POST" action="{{ route('servicios.update', $servicio) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Sin categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id', $servicio->categoria_id)==$cat->id?'selected':'' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $servicio->nombre) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio', $servicio->precio) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Duración (min)</label>
                    <input type="number" name="duracion_minutos" class="form-control" value="{{ old('duracion_minutos', $servicio->duracion_minutos) }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $servicio->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
