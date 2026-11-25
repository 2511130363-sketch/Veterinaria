<?php

namespace App\Http\Controllers;

use App\Exports\ReporteExport;
use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Consulta;
use App\Models\DetalleVenta;
use App\Models\Mascota;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function clientes(Request $request)
    {
        $clientes = Cliente::withCount('mascotas')->latest()->get();

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.clientes', compact('clientes'));
            return $pdf->download('reporte_clientes.pdf');
        }
        if ($request->get('export') === 'excel') {
            $rows = $clientes->map(fn ($c) => [
                $c->id, $c->nombres, $c->apellidos, $c->dni, $c->telefono, $c->email, $c->direccion, $c->mascotas_count,
            ])->toArray();
            return Excel::download(new ReporteExport(
                ['ID', 'Nombres', 'Apellidos', 'DNI', 'Teléfono', 'Email', 'Dirección', 'Mascotas'],
                $rows
            ), 'reporte_clientes.xlsx');
        }

        return view('reportes.clientes', compact('clientes'));
    }

    public function mascotas(Request $request)
    {
        $mascotas = Mascota::with('cliente')->latest()->get();

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.mascotas', compact('mascotas'));
            return $pdf->download('reporte_mascotas.pdf');
        }
        if ($request->get('export') === 'excel') {
            $rows = $mascotas->map(fn ($m) => [
                $m->id, $m->nombre, $m->especie, $m->raza, $m->sexo, $m->fecha_nacimiento?->format('Y-m-d'), $m->peso, $m->cliente?->nombre_completo,
            ])->toArray();
            return Excel::download(new ReporteExport(
                ['ID', 'Nombre', 'Especie', 'Raza', 'Sexo', 'Nacimiento', 'Peso', 'Propietario'],
                $rows
            ), 'reporte_mascotas.xlsx');
        }

        return view('reportes.mascotas', compact('mascotas'));
    }

    public function citas(Request $request)
    {
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $estado = $request->get('estado');

        $citas = Cita::with(['cliente', 'mascota', 'veterinario'])
            ->when($desde, fn ($q) => $q->whereDate('fecha', '>=', $desde))
            ->when($hasta, fn ($q) => $q->whereDate('fecha', '<=', $hasta))
            ->when($estado, fn ($q) => $q->where('estado', $estado))
            ->orderBy('fecha')->orderBy('hora')->get();

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.citas', compact('citas', 'desde', 'hasta'));
            return $pdf->download('reporte_citas.pdf');
        }
        if ($request->get('export') === 'excel') {
            $rows = $citas->map(fn ($c) => [
                $c->id, $c->fecha?->format('Y-m-d'), $c->hora, $c->cliente?->nombre_completo, $c->mascota?->nombre, $c->veterinario?->nombre_completo, $c->estado, $c->motivo,
            ])->toArray();
            return Excel::download(new ReporteExport(
                ['ID', 'Fecha', 'Hora', 'Cliente', 'Mascota', 'Veterinario', 'Estado', 'Motivo'],
                $rows
            ), 'reporte_citas.xlsx');
        }

        return view('reportes.citas', compact('citas', 'desde', 'hasta', 'estado'));
    }

    public function consultas(Request $request)
    {
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');

        $consultas = Consulta::with(['mascota.cliente', 'veterinario'])
            ->when($desde, fn ($q) => $q->whereDate('fecha', '>=', $desde))
            ->when($hasta, fn ($q) => $q->whereDate('fecha', '<=', $hasta))
            ->latest('fecha')->get();

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.consultas', compact('consultas', 'desde', 'hasta'));
            return $pdf->download('reporte_consultas.pdf');
        }
        if ($request->get('export') === 'excel') {
            $rows = $consultas->map(fn ($c) => [
                $c->id, $c->fecha?->format('Y-m-d'), $c->mascota?->nombre, $c->mascota?->cliente?->nombre_completo, $c->veterinario?->nombre_completo, $c->diagnostico, $c->peso, $c->temperatura,
            ])->toArray();
            return Excel::download(new ReporteExport(
                ['ID', 'Fecha', 'Mascota', 'Propietario', 'Veterinario', 'Diagnóstico', 'Peso', 'Temp'],
                $rows
            ), 'reporte_consultas.xlsx');
        }

        return view('reportes.consultas', compact('consultas', 'desde', 'hasta'));
    }

    public function servicios(Request $request)
    {
        $servicios = DetalleVenta::whereNotNull('servicio_id')
            ->selectRaw('servicio_id, count(*) as total, sum(subtotal) as monto')
            ->groupBy('servicio_id')
            ->with('servicio')
            ->get();

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.servicios', compact('servicios'));
            return $pdf->download('reporte_servicios.pdf');
        }
        if ($request->get('export') === 'excel') {
            $rows = $servicios->map(fn ($s) => [
                $s->servicio?->nombre, $s->total, $s->monto,
            ])->toArray();
            return Excel::download(new ReporteExport(
                ['Servicio', 'Cantidad', 'Monto'],
                $rows
            ), 'reporte_servicios.xlsx');
        }

        return view('reportes.servicios', compact('servicios'));
    }

    public function ventas(Request $request)
    {
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');

        $ventas = Venta::with(['cliente', 'user', 'detalles'])
            ->when($desde, fn ($q) => $q->whereDate('fecha', '>=', $desde))
            ->when($hasta, fn ($q) => $q->whereDate('fecha', '<=', $hasta))
            ->latest()->get();

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.ventas', compact('ventas', 'desde', 'hasta'));
            return $pdf->download('reporte_ventas.pdf');
        }
        if ($request->get('export') === 'excel') {
            $rows = $ventas->map(fn ($v) => [
                $v->id, $v->fecha?->format('Y-m-d'), $v->cliente?->nombre_completo, $v->total, $v->metodo_pago, $v->estado,
            ])->toArray();
            return Excel::download(new ReporteExport(
                ['ID', 'Fecha', 'Cliente', 'Total', 'Método', 'Estado'],
                $rows
            ), 'reporte_ventas.xlsx');
        }

        return view('reportes.ventas', compact('ventas', 'desde', 'hasta'));
    }

    public function ingresos(Request $request)
    {
        $desde = $request->get('desde', now()->startOfMonth()->toDateString());
        $hasta = $request->get('hasta', now()->toDateString());

        $ingresos = Venta::selectRaw('fecha, count(*) as ventas, sum(total) as total')
            ->whereDate('fecha', '>=', $desde)
            ->whereDate('fecha', '<=', $hasta)
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        $totalGeneral = $ingresos->sum('total');

        if ($request->get('export') === 'pdf') {
            $pdf = Pdf::loadView('reportes.pdf.ingresos', compact('ingresos', 'desde', 'hasta', 'totalGeneral'));
            return $pdf->download('reporte_ingresos.pdf');
        }
        if ($request->get('export') === 'excel') {
            $rows = $ingresos->map(fn ($i) => [
                $i->fecha, $i->ventas, $i->total,
            ])->toArray();
            return Excel::download(new ReporteExport(
                ['Fecha', 'Ventas', 'Total'],
                $rows
            ), 'reporte_ingresos.xlsx');
        }

        return view('reportes.ingresos', compact('ingresos', 'desde', 'hasta', 'totalGeneral'));
    }
}
