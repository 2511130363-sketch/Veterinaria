@extends('layouts.app')
@section('title', 'Nueva cita')

@section('content')
<div class="card">
    <div class="card-header">Programar cita</div>
    <div class="card-body">
        <form method="POST" action="{{ route('citas.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mascota</label>
                    <select name="mascota_id" id="mascota_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($mascotas as $m)
                            <option value="{{ $m->id }}" data-cliente="{{ $m->cliente_id }}">{{ $m->nombre }} ({{ $m->cliente->nombre_completo ?? '' }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Veterinario</label>
                    <select name="veterinario_id" class="form-select" required>
                        <option value="">Seleccione</option>
                        @foreach($veterinarios as $v)
                            <option value="{{ $v->id }}">{{ $v->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora</label>
                    <input type="time" name="hora" class="form-control" value="{{ old('hora') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Estado</label>
                    <select name="estado" class="form-select" required>
                        @foreach(['pendiente','confirmada','atendida','cancelada'] as $e)
                            <option value="{{ $e }}" {{ old('estado','pendiente')==$e?'selected':'' }}>{{ $e }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label">Motivo</label>
                    <textarea name="motivo" class="form-control" rows="2">{{ old('motivo') }}</textarea>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('citas.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('cliente_id').addEventListener('change', function() {
    const cid = this.value;
    const sel = document.getElementById('mascota_id');
    Array.from(sel.options).forEach(opt => {
        if (!opt.value) return;
        opt.hidden = cid && opt.dataset.cliente !== cid;
    });
    sel.value = '';
});
</script>
@endsection
