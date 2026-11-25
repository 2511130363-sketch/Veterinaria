<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\InventarioMovimiento;
use App\Models\Pago;
use App\Models\Producto;
use App\Models\Servicio;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');

        $ventas = Venta::with(['cliente', 'user'])
            ->when($desde, fn ($q) => $q->whereDate('fecha', '>=', $desde))
            ->when($hasta, fn ($q) => $q->whereDate('fecha', '<=', $hasta))
            ->latest()->paginate(15)->withQueryString();

        return view('ventas.index', compact('ventas', 'desde', 'hasta'));
    }

    public function create()
    {
        $clientes = \App\Models\Cliente::where('activo', true)->orderBy('nombres')->get();
        $servicios = Servicio::where('activo', true)->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        return view('ventas.create', compact('clientes', 'servicios', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'metodo_pago' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.tipo' => 'required|in:servicio,producto',
            'items.*.id' => 'required|integer',
            'items.*.cantidad' => 'required|integer|min:1',
            'items.*.precio' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $subtotal = 0;
            foreach ($request->items as $item) {
                $subtotal += $item['cantidad'] * $item['precio'];
            }
            $total = $subtotal;

            $venta = Venta::create([
                'cliente_id' => $request->cliente_id,
                'user_id' => auth()->id(),
                'fecha' => now()->toDateString(),
                'subtotal' => $subtotal,
                'total' => $total,
                'metodo_pago' => $request->metodo_pago,
                'estado' => 'pagada',
            ]);

            foreach ($request->items as $item) {
                $servicioId = null;
                $productoId = null;
                $descripcion = '';

                if ($item['tipo'] === 'servicio') {
                    $servicio = Servicio::findOrFail($item['id']);
                    $servicioId = $servicio->id;
                    $descripcion = $servicio->nombre;
                } else {
                    $producto = Producto::lockForUpdate()->findOrFail($item['id']);
                    if ($producto->stock < $item['cantidad']) {
                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'items' => 'Stock insuficiente para ' . $producto->nombre,
                        ]);
                    }
                    $producto->decrement('stock', $item['cantidad']);
                    $productoId = $producto->id;
                    $descripcion = $producto->nombre;

                    InventarioMovimiento::create([
                        'producto_id' => $producto->id,
                        'user_id' => auth()->id(),
                        'tipo' => 'salida',
                        'cantidad' => $item['cantidad'],
                        'motivo' => 'Venta #' . $venta->id,
                    ]);
                }

                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'servicio_id' => $servicioId,
                    'producto_id' => $productoId,
                    'descripcion' => $descripcion,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['cantidad'] * $item['precio'],
                ]);
            }

            Pago::create([
                'venta_id' => $venta->id,
                'monto' => $total,
                'metodo' => $request->metodo_pago,
                'fecha' => now()->toDateString(),
            ]);
        });

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        $venta->load(['cliente', 'user', 'detalles.servicio', 'detalles.producto', 'pagos']);
        return view('ventas.show', compact('venta'));
    }

    public function destroy(Venta $venta)
    {
        $venta->update(['estado' => 'anulada']);
        return redirect()->route('ventas.index')->with('success', 'Venta anulada correctamente.');
    }
}
