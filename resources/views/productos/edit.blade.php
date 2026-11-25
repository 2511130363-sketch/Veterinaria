@extends('layouts.app')
@section('title', 'Editar producto')

@section('content')
<div class="card">
    <div class="card-header">Editar producto</div>
    <div class="card-body">
        <form method="POST" action="{{ route('productos.update', $producto) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Sin categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id', $producto->categoria_id)==$cat->id?'selected':'' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label">P. compra</label>
                    <input type="number" step="0.01" name="precio_compra" class="form-control" value="{{ old('precio_compra', $producto->precio_compra) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">P. venta</label>
                    <input type="number" step="0.01" name="precio_venta" class="form-control" value="{{ old('precio_venta', $producto->precio_venta) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $producto->stock) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock mínimo</label>
                    <input type="number" name="stock_minimo" class="form-control" value="{{ old('stock_minimo', $producto->stock_minimo) }}" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $producto->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
