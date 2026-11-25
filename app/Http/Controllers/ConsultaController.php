<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Mascota;
use App\Models\Tratamiento;
use App\Models\Veterinario;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $mascota_id = $request->get('mascota_id');
        $veterinario_id = $request->get('veterinario_id');

        $user = auth()->user();
        $consultas = Consulta::with(['mascota.cliente', 'veterinario'])
            ->when($user->isVeterinario(), function ($q) use ($user) {
                $vet = \App\Models\Veterinario::where('user_id', $user->id)->first();
                if ($vet) $q->where('veterinario_id', $vet->id);
            })
            ->when($mascota_id, fn ($q) => $q->where('mascota_id', $mascota_id))
            ->when($veterinario_id, fn ($q) => $q->where('veterinario_id', $veterinario_id))
            ->latest('fecha')->paginate(15)->withQueryString();

        $mascotas = Mascota::orderBy('nombre')->get();
        $veterinarios = Veterinario::where('activo', true)->orderBy('nombres')->get();

        return view('consultas.index', compact('consultas', 'mascotas', 'veterinarios', 'mascota_id', 'veterinario_id'));
    }

    public function create(Request $request)
    {
        $mascotas = Mascota::with('cliente')->where('activo', true)->orderBy('nombre')->get();
        $veterinarios = Veterinario::where('activo', true)->orderBy('nombres')->get();
        $cita = $request->get('cita_id') ? Cita::find($request->get('cita_id')) : null;
        return view('consultas.create', compact('mascotas', 'veterinarios', 'cita'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:veterinarios,id',
            'cita_id' => 'nullable|exists:citas,id',
            'fecha' => 'required|date',
            'sintomas' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'peso' => 'nullable|numeric|min:0',
            'temperatura' => 'nullable|numeric|min:0',
        ]);

        $consulta = Consulta::create($data);

        // Tratamientos dinámicos
        $nombres = $request->input('trat_nombre', []);
        $descripciones = $request->input('trat_descripcion', []);
        $dosis = $request->input('trat_dosis', []);
        $frecuencias = $request->input('trat_frecuencia', []);
        $duraciones = $request->input('trat_duracion', []);
        foreach ($nombres as $i => $nombre) {
            if (trim($nombre) === '') continue;
            Tratamiento::create([
                'consulta_id' => $consulta->id,
                'nombre' => $nombre,
                'descripcion' => $descripciones[$i] ?? null,
                'dosis' => $dosis[$i] ?? null,
                'frecuencia' => $frecuencias[$i] ?? null,
                'duracion' => $duraciones[$i] ?? null,
            ]);
        }

        if ($consulta->cita_id) {
            Cita::where('id', $consulta->cita_id)->update(['estado' => 'atendida']);
        }

        return redirect()->route('consultas.index')->with('success', 'Consulta registrada correctamente.');
    }

    public function show(Consulta $consulta)
    {
        $consulta->load('mascota.cliente', 'veterinario', 'cita', 'tratamientos');
        return view('consultas.show', compact('consulta'));
    }

    public function edit(Consulta $consulta)
    {
        $consulta->load('tratamientos');
        $mascotas = Mascota::with('cliente')->where('activo', true)->orderBy('nombre')->get();
        $veterinarios = Veterinario::where('activo', true)->orderBy('nombres')->get();
        return view('consultas.edit', compact('consulta', 'mascotas', 'veterinarios'));
    }

    public function update(Request $request, Consulta $consulta)
    {
        $data = $request->validate([
            'mascota_id' => 'required|exists:mascotas,id',
            'veterinario_id' => 'required|exists:veterinarios,id',
            'cita_id' => 'nullable|exists:citas,id',
            'fecha' => 'required|date',
            'sintomas' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'tratamiento' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'peso' => 'nullable|numeric|min:0',
            'temperatura' => 'nullable|numeric|min:0',
        ]);

        $consulta->update($data);

        // Reemplazar tratamientos
        $consulta->tratamientos()->delete();
        $nombres = $request->input('trat_nombre', []);
        $descripciones = $request->input('trat_descripcion', []);
        $dosis = $request->input('trat_dosis', []);
        $frecuencias = $request->input('trat_frecuencia', []);
        $duraciones = $request->input('trat_duracion', []);
        foreach ($nombres as $i => $nombre) {
            if (trim($nombre) === '') continue;
            Tratamiento::create([
                'consulta_id' => $consulta->id,
                'nombre' => $nombre,
                'descripcion' => $descripciones[$i] ?? null,
                'dosis' => $dosis[$i] ?? null,
                'frecuencia' => $frecuencias[$i] ?? null,
                'duracion' => $duraciones[$i] ?? null,
            ]);
        }

        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada correctamente.');
    }

    public function destroy(Consulta $consulta)
    {
        $consulta->delete();
        return redirect()->route('consultas.index')->with('success', 'Consulta eliminada correctamente.');
    }
}
