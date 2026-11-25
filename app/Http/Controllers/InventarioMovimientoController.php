<?php

namespace App\Http\Controllers;

use App\Models\InventarioMovimiento;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioMovimientoController extends Controller
{
    public function index(Request $request)
    {
        $movimientos = InventarioMovimiento::with(['producto', 'user'])
            ->latest()->paginate(15);

        return view('inventario.index', compact('movimientos'));
    }

    public function create()
    {
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        return view('inventario.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'cantidad' => 'required|integer|min:1',
            'motivo' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $producto = Producto::lockForUpdate()->findOrFail($data['producto_id']);

            if ($data['tipo'] === 'salida' && $producto->stock < $data['cantidad']) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'cantidad' => 'Stock insuficiente. Disponible: ' . $producto->stock,
                ]);
            }

            if ($data['tipo'] === 'entrada') {
                $producto->increment('stock', $data['cantidad']);
            } else {
                $producto->decrement('stock', $data['cantidad']);
            }

            InventarioMovimiento::create([
                'producto_id' => $data['producto_id'],
                'user_id' => auth()->id(),
                'tipo' => $data['tipo'],
                'cantidad' => $data['cantidad'],
                'motivo' => $data['motivo'],
            ]);
        });

        return redirect()->route('inventario.index')->with('success', 'Movimiento registrado correctamente.');
    }
}
