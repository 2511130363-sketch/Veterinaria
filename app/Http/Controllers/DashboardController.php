<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Consulta;
use App\Models\Mascota;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();

        $totalMascotas = Mascota::count();
        $totalClientes = Cliente::count();
        $citasHoy = Cita::whereDate('fecha', $hoy)->count();
        $consultasRealizadas = Consulta::count();

        $ingresosHoy = Venta::whereDate('fecha', $hoy)->sum('total');
        $ingresosMes = Venta::whereYear('fecha', $hoy->year)
            ->whereMonth('fecha', $hoy->month)
            ->sum('total');

        $ultimasCitas = Cita::with(['cliente', 'mascota', 'veterinario'])
            ->latest()->take(5)->get();

        $proximasCitas = Cita::with(['cliente', 'mascota', 'veterinario'])
            ->whereDate('fecha', '>=', $hoy)
            ->orderBy('fecha')->orderBy('hora')
            ->take(5)->get();

        // Gráfico ingresos últimos 7 días
        $ingresos7 = [];
        for ($i = 6; $i >= 0; $i--) {
            $d = $hoy->copy()->subDays($i);
            $ingresos7[] = [
                'fecha' => $d->format('d/m'),
                'total' => (float) Venta::whereDate('fecha', $d)->sum('total'),
            ];
        }

        // Consultas por mes (últimos 6 meses)
        $consultas6 = [];
        for ($i = 5; $i >= 0; $i--) {
            $d = $hoy->copy()->subMonths($i);
            $consultas6[] = [
                'mes' => $d->format('M'),
                'total' => Consulta::whereYear('fecha', $d->year)->whereMonth('fecha', $d->month)->count(),
            ];
        }

        return view('dashboard', compact(
            'totalMascotas', 'totalClientes', 'citasHoy', 'consultasRealizadas',
            'ingresosHoy', 'ingresosMes', 'ultimasCitas', 'proximasCitas',
            'ingresos7', 'consultas6'
        ));
    }
}
