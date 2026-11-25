<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index(Request $request)
    {
        $fecha = $request->get('fecha');
        $veterinario_id = $request->get('veterinario_id');
        $estado = $request->get('estado');

        $user = auth()->user();
        $citas = Cita::with(['cliente', 'mascota', 'veterinario'])
            ->when($user->isVeterinario(), function ($q) use ($user) {
                $vet = \App\Models\Veterinario::where('user_id', $user->id)->first();
                if ($vet) $q->where('veterinario_id', $vet->id);
            })
            ->when($fecha, fn ($q) => $q->whereDate('fecha', $fecha))
            ->when($veterinario_id, fn ($q) => $q->where('veterinario_id', $veterinario_id))
            ->when($estado, fn ($q) => $q->where('estado', $estado))
            ->orderBy('fecha')->orderBy('hora')
            ->paginate(15)->withQueryString();

        $veterinarios = Veterinario::where('activo', true)->orderBy('nombres')->get();

        return view('citas.index', compact('citas', 'veterinarios', 'fecha', 'veterinario_id', 'estado'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombres')->get();
        $mascotas = Mascota::where('activo', true)->orderBy('nombre')->get();
        $veterinarios = Veterinario::where('activo', true)->orderBy('nombres')->get();
        return view('citas.create', compact('clientes', 'mascotas', 'veterinarios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'motivo' => 'nullable|string',
            'estado' => 'required|in:pendiente,confirmada,atendida,cancelada',
        ]);

        try {
            Cita::create($data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['hora' => 'Ya existe una cita para ese veterinario en ese horario.']);
        }

        return redirect()->route('citas.index')->with('success', 'Cita programada correctamente.');
    }

    public function show(Cita $cita)
    {
        $cita->load('cliente', 'mascota', 'veterinario', 'consulta');
        return view('citas.show', compact('cita'));
    }

    public function edit(Cita $cita)
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombres')->get();
        $mascotas = Mascota::where('activo', true)->orderBy('nombre')->get();
        $veterinarios = Veterinario::where('activo', true)->orderBy('nombres')->get();
        return view('citas.edit', compact('cita', 'clientes', 'mascotas', 'veterinarios'));
    }

    public function update(Request $request, Cita $cita)
    {
        $data = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:veterinarios,id',
            'fecha' => 'required|date',
            'hora' => 'required',
            'motivo' => 'nullable|string',
            'estado' => 'required|in:pendiente,confirmada,atendida,cancelada',
        ]);

        try {
            $cita->update($data);
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withInput()->withErrors(['hora' => 'Ya existe una cita para ese veterinario en ese horario.']);
        }

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    public function destroy(Cita $cita)
    {
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }
}
