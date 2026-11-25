<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $recepRole = Role::where('slug', 'recepcionista')->first();
        $vetRole = Role::where('slug', 'veterinario')->first();

        User::firstOrCreate(['email' => 'admin@veterinaria.com'], [
            'name' => 'Administrador',
            'password' => bcrypt('password'),
            'role_id' => $adminRole?->id,
        ]);

        User::firstOrCreate(['email' => 'recepcion@veterinaria.com'], [
            'name' => 'Recepcionista',
            'password' => bcrypt('password'),
            'role_id' => $recepRole?->id,
        ]);

        $vetUser = User::firstOrCreate(['email' => 'veterinario@veterinaria.com'], [
            'name' => 'Veterinario',
            'password' => bcrypt('password'),
            'role_id' => $vetRole?->id,
        ]);

        \App\Models\Veterinario::firstOrCreate(['user_id' => $vetUser->id], [
            'nombres' => 'Juan',
            'apellidos' => 'Pérez',
            'especialidad' => 'Medicina general',
            'colegiatura' => 'CMV-001',
            'telefono' => '999888777',
            'email' => 'veterinario@veterinaria.com',
            'activo' => true,
        ]);
    }
}
