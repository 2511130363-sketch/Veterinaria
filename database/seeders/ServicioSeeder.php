<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Categoria::where('tipo', 'servicio')->first();
        $servicios = [
            ['nombre' => 'Consulta general', 'precio' => 50, 'duracion_minutos' => 30],
            ['nombre' => 'Vacunación', 'precio' => 80, 'duracion_minutos' => 20],
            ['nombre' => 'Desparasitación', 'precio' => 60, 'duracion_minutos' => 20],
            ['nombre' => 'Baño y peluquería', 'precio' => 90, 'duracion_minutos' => 60],
            ['nombre' => 'Cirugía menor', 'precio' => 300, 'duracion_minutos' => 90],
            ['nombre' => 'Emergencia', 'precio' => 150, 'duracion_minutos' => 45],
            ['nombre' => 'Análisis clínico', 'precio' => 120, 'duracion_minutos' => 30],
        ];
        foreach ($servicios as $s) {
            Servicio::firstOrCreate(['nombre' => $s['nombre']], array_merge($s, ['categoria_id' => $cat?->id, 'activo' => true]));
        }
    }
}
