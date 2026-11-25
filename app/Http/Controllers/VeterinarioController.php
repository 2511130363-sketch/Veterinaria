<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class VeterinarioController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $veterinarios = Veterinario::with('user')
            ->when($q, function ($query) use ($q) {
                $query->where('nombres', 'like', "%{$q}%")
                    ->orWhere('apellidos', 'like', "%{$q}%")
                    ->orWhere('especialidad', 'like', "%{$q}%")
                    ->orWhere('colegiatura', 'like', "%{$q}%");
            })->latest()->paginate(10)->withQueryString();

        return view('veterinarios.index', compact('veterinarios', 'q'));
    }

    public function create()
    {
        $users = User::whereHas('role', fn ($r) => $r->where('slug', 'veterinario'))->get();
        return view('veterinarios.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'colegiatura' => 'nullable|string|max:50|unique:veterinarios,colegiatura',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo', true);

        Veterinario::create($data);

        return redirect()->route('veterinarios.index')->with('success', 'Veterinario registrado correctamente.');
    }

    public function show(Veterinario $veterinario)
    {
        $veterinario->load('user', 'citas', 'consultas');
        return view('veterinarios.show', compact('veterinario'));
    }

    public function edit(Veterinario $veterinario)
    {
        $users = User::whereHas('role', fn ($r) => $r->where('slug', 'veterinario'))->get();
        return view('veterinarios.edit', compact('veterinario', 'users'));
    }

    public function update(Request $request, Veterinario $veterinario)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'colegiatura' => 'nullable|string|max:50|unique:veterinarios,colegiatura,' . $veterinario->id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo');

        $veterinario->update($data);

        return redirect()->route('veterinarios.index')->with('success', 'Veterinario actualizado correctamente.');
    }

    public function destroy(Veterinario $veterinario)
    {
        $veterinario->delete();
        return redirect()->route('veterinarios.index')->with('success', 'Veterinario eliminado correctamente.');
    }
}
