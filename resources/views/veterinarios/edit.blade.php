@extends('layouts.app')
@section('title', 'Editar veterinario')

@section('content')
<div class="card">
    <div class="card-header">Editar veterinario</div>
    <div class="card-body">
        <form method="POST" action="{{ route('veterinarios.update', $veterinario) }}">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Usuario asociado</label>
                    <select name="user_id" class="form-select">
                        <option value="">Sin usuario</option>
                        @foreach($users as $u)
                            <option value="{{ $u->id }}" {{ old('user_id', $veterinario->user_id)==$u->id?'selected':'' }}>{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nombres</label>
                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $veterinario->nombres) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $veterinario->apellidos) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Especialidad</label>
                    <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $veterinario->especialidad) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Colegiatura</label>
                    <input type="text" name="colegiatura" class="form-control" value="{{ old('colegiatura', $veterinario->colegiatura) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $veterinario->telefono) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $veterinario->email) }}">
                </div>
                <div class="col-12">
                    <div class="form-check">
                        <input type="checkbox" name="activo" value="1" class="form-check-input" id="activo" {{ old('activo', $veterinario->activo) ? 'checked' : '' }}>
                        <label class="form-check-label" for="activo">Activo</label>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('veterinarios.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
