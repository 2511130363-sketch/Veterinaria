@extends('layouts.app')
@section('title', 'Nuevo movimiento')

@section('content')
<div class="card">
    <div class="card-header">Registrar movimiento de inventario</div>
    <div class="card-body">
        <form method="POST" action="{{ route('inventario.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($productos as $p)
                            <option value="{{ $p->id }}" {{ old('producto_id')==$p->id?'selected':'' }}>{{ $p->nombre }} (stock: {{ $p->stock }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tipo</label>
                    <select name="tipo" class="form-select" required>
                        <option value="entrada" {{ old('tipo')=='entrada'?'selected':'' }}>Entrada</option>
                        <option value="salida" {{ old('tipo')=='salida'?'selected':'' }}>Salida</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', 1) }}" min="1" required>
                </div>
                <div class="col-12">
                    <label class="form-label">Motivo</label>
                    <input type="text" name="motivo" class="form-control" value="{{ old('motivo') }}">
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
