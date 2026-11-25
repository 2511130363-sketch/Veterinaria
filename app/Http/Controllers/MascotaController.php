<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mascota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MascotaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $mascotas = Mascota::with('cliente')
            ->when($q, function ($query) use ($q) {
                $query->where('nombre', 'like', "%{$q}%")
                    ->orWhere('especie', 'like', "%{$q}%")
                    ->orWhere('raza', 'like', "%{$q}%")
                    ->orWhereHas('cliente', function ($c) use ($q) {
                        $c->where('nombres', 'like', "%{$q}%")
                            ->orWhere('apellidos', 'like', "%{$q}%");
                    });
            })->latest()->paginate(10)->withQueryString();

        return view('mascotas.index', compact('mascotas', 'q'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombres')->get();
        return view('mascotas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'sexo' => 'required|in:macho,hembra',
            'fecha_nacimiento' => 'nullable|date',
            'peso' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:50',
            'foto' => 'nullable|image|max:2048',
            'activo' => 'boolean',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('mascotas', 'public');
        }
        $data['activo'] = $request->boolean('activo', true);

        Mascota::create($data);

        return redirect()->route('mascotas.index')->with('success', 'Mascota registrada correctamente.');
    }

    public function show(Mascota $mascota)
    {
        $mascota->load('cliente', 'consultas.veterinario', 'citas.veterinario');
        return view('mascotas.show', compact('mascota'));
    }

    public function edit(Mascota $mascota)
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombres')->get();
        return view('mascotas.edit', compact('mascota', 'clientes'));
    }

    public function update(Request $request, Mascota $mascota)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'nombre' => 'required|string|max:100',
            'especie' => 'required|string|max:50',
            'raza' => 'nullable|string|max:50',
            'sexo' => 'required|in:macho,hembra',
            'fecha_nacimiento' => 'nullable|date',
            'peso' => 'nullable|numeric|min:0',
            'color' => 'nullable|string|max:50',
            'foto' => 'nullable|image|max:2048',
            'activo' => 'boolean',
        ]);

        if ($request->hasFile('foto')) {
            if ($mascota->foto) {
                Storage::disk('public')->delete($mascota->foto);
            }
            $data['foto'] = $request->file('foto')->store('mascotas', 'public');
        }
        $data['activo'] = $request->boolean('activo');

        $mascota->update($data);

        return redirect()->route('mascotas.index')->with('success', 'Mascota actualizada correctamente.');
    }

    public function destroy(Mascota $mascota)
    {
        if ($mascota->foto) {
            Storage::disk('public')->delete($mascota->foto);
        }
        $mascota->delete();
        return redirect()->route('mascotas.index')->with('success', 'Mascota eliminada correctamente.');
    }
}
