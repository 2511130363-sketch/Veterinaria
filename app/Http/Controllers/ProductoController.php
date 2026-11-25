<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $productos = Producto::with('categoria')
            ->when($q, function ($query) use ($q) {
                $query->where('nombre', 'like', "%{$q}%");
            })->latest()->paginate(10)->withQueryString();

        $stockBajo = Producto::whereColumn('stock', '<=', 'stock_minimo')->count();

        return view('productos.index', compact('productos', 'q', 'stockBajo'));
    }

    public function create()
    {
        $categorias = Categoria::where('tipo', 'producto')->where('activo', true)->get();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo', true);

        Producto::create($data);

        return redirect()->route('productos.index')->with('success', 'Producto registrado correctamente.');
    }

    public function show(Producto $producto)
    {
        $producto->load('categoria', 'movimientos.user');
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::where('tipo', 'producto')->where('activo', true)->get();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $data = $request->validate([
            'categoria_id' => 'nullable|exists:categorias,id',
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo');

        $producto->update($data);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
