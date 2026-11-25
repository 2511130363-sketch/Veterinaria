@extends('layouts.app')
@section('title', 'Nuevo producto')

@section('content')
<div class="card">
    <div class="card-header">Registrar producto</div>
    <div class="card-body">
        <form method="POST" action="{{ route('productos.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Categoría</label>
                    <select name="categoria_id" class="form-select">
                        <option value="">Sin categoría</option>
                        @foreach($categorias as $cat)
                            <option value="{{ $cat->id }}" {{ old('categoria_id')==$cat->id?'selected':'' }}>{{ $cat->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="2">{{ old('descripcion') }}</textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label">P. compra</label>
                    <input type="number" step="0.01" name="precio_compra" class="form-control" value="{{ old('precio_compra') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">P. venta</label>
                    <input type="number" step="0.01" name="precio_venta" class="form-control" value="{{ old('precio_venta') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock mínimo</label>
                    <input type="number" name="stock_minimo" class="form-control" value="{{ old('stock_minimo', 5) }}" required>
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" checked>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
