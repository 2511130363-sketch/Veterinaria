<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarioMovimientoController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\VeterinarioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Admin + Recepcionista
    Route::middleware('role:admin,recepcionista')->group(function () {
        Route::resource('clientes', ClienteController::class);
        Route::resource('mascotas', MascotaController::class);
        Route::resource('citas', CitaController::class)->except(['index', 'show']);
        Route::resource('ventas', VentaController::class)->only(['index', 'create', 'store', 'show', 'destroy']);
    });

    // Admin only (gestión)
    Route::middleware('role:admin')->group(function () {
        Route::resource('veterinarios', VeterinarioController::class);
        Route::resource('servicios', ServicioController::class);
        Route::resource('productos', ProductoController::class);
        Route::resource('categorias', CategoriaController::class);
        Route::resource('inventario', InventarioMovimientoController::class)->only(['index', 'create', 'store']);
        Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
        Route::get('reportes/clientes', [ReporteController::class, 'clientes'])->name('reportes.clientes');
        Route::get('reportes/mascotas', [ReporteController::class, 'mascotas'])->name('reportes.mascotas');
        Route::get('reportes/citas', [ReporteController::class, 'citas'])->name('reportes.citas');
        Route::get('reportes/consultas', [ReporteController::class, 'consultas'])->name('reportes.consultas');
        Route::get('reportes/servicios', [ReporteController::class, 'servicios'])->name('reportes.servicios');
        Route::get('reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
        Route::get('reportes/ingresos', [ReporteController::class, 'ingresos'])->name('reportes.ingresos');
    });

    // Citas: visualización para veterinarios también
    Route::middleware('role:admin,recepcionista,veterinario')->group(function () {
        Route::get('citas', [CitaController::class, 'index'])->name('citas.index');
        Route::get('citas/{cita}', [CitaController::class, 'show'])->name('citas.show');
    });

    // Veterinario + Admin: consultas
    Route::middleware('role:admin,veterinario,recepcionista')->group(function () {
        Route::resource('consultas', ConsultaController::class);
    });

    // Citas para veterinario (solo sus citas?) - admin/recepcionista ya tienen; vet needs view
    Route::middleware('role:veterinario')->group(function () {
        Route::get('mis-citas', [CitaController::class, 'index'])->name('veterinario.citas');
    });
});

require __DIR__.'/auth.php';
