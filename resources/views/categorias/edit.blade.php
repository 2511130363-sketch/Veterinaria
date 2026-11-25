@extends('layouts.app')
@section('title', 'Editar categoría')

@section('content')
<div class="card">
    <div class="card-header">Editar categoría</div>
    <div class="card-body">
        <form method="POST" action="{{ route('categorias.update', $categoria) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select" required>
                        <option value="servicio" {{ old('tipo', $categoria->tipo)=='servicio'?'selected':'' }}>Servicio</option>
                        <option value="producto" {{ old('tipo', $categoria->tipo)=='producto'?'selected':'' }}>Producto</option>
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $categoria->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('categorias.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
