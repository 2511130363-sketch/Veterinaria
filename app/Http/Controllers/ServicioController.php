<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $servicios = Servicio::with('categoria')
            ->when($q, function ($query) use ($q) {
                $query->where('nombre', 'like', "%{$q}%");
            })->latest()->paginate(10)->withQueryString();

        return view('servicios.index', compact('servicios', 'q'));
    }

    public function create()
    {
        $categorias = Categoria::where('tipo', 'servicio')->where('activo', true)->get();
        return view('servicios.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo', true);

        Servicio::create($data);

        return redirect()->route('servicios.index')->with('success', 'Servicio registrado correctamente.');
    }

    public function show(Servicio $servicio)
    {
        return view('servicios.show', compact('servicio'));
    }

    public function edit(Servicio $servicio)
    {
        $categorias = Categoria::where('tipo', 'servicio')->where('activo', true)->get();
        return view('servicios.edit', compact('servicio', 'categorias'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'duracion_minutos' => 'nullable|integer|min:0',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo');

        $servicio->update($data);

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}
