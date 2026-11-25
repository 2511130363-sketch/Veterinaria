<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nombre' => 'Administrador', 'slug' => 'admin', 'descripcion' => 'Acceso completo al sistema'],
            ['nombre' => 'Recepcionista', 'slug' => 'recepcionista', 'descripcion' => 'Clientes, mascotas, citas y ventas'],
            ['nombre' => 'Veterinario', 'slug' => 'veterinario', 'descripcion' => 'Citas asignadas e historiales clínicos'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
