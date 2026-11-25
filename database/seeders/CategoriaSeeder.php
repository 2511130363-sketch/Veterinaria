<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $servicios = ['Consulta', 'Vacunación', 'Cirugía', 'Estética', 'Laboratorio'];
        foreach ($servicios as $s) {
            Categoria::firstOrCreate(['nombre' => $s, 'tipo' => 'servicio']);
        }
        $productos = ['Medicamentos', 'Alimentos', 'Accesorios', 'Higiene'];
        foreach ($productos as $p) {
            Categoria::firstOrCreate(['nombre' => $p, 'tipo' => 'producto']);
        }
    }
}
