<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $clientes = Cliente::when($q, function ($query) use ($q) {
            $query->where('nombres', 'like', "%{$q}%")
                ->orWhere('apellidos', 'like', "%{$q}%")
                ->orWhere('dni', 'like', "%{$q}%")
                ->orWhere('telefono', 'like', "%{$q}%")
                ->orWhere('email', 'like', "%{$q}%");
        })->latest()->paginate(10)->withQueryString();

        return view('clientes.index', compact('clientes', 'q'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|max:20|unique:clientes,dni',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo', true);

        Cliente::create($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Cliente $cliente)
    {
        $cliente->load('mascotas', 'ventas');
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $data = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'dni' => 'required|string|max:20|unique:clientes,dni,' . $cliente->id,
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'direccion' => 'nullable|string|max:255',
            'activo' => 'boolean',
        ]);
        $data['activo'] = $request->boolean('activo');

        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }
}
