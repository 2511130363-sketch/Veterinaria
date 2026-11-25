<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::latest()->paginate(15);
        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:servicio,producto',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo', true);
        Categoria::create($data);
        return redirect()->route('categorias.index')->with('success', 'Categoría creada.');
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo' => 'required|in:servicio,producto',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo');
        $categoria->update($data);
        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada.');
    }
}
