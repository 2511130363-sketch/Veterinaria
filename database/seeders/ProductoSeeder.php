<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $cat = Categoria::where('tipo', 'producto')->first();
        $productos = [
            ['nombre' => 'Antipulgas', 'precio_compra' => 20, 'precio_venta' => 35, 'stock' => 15, 'stock_minimo' => 5],
            ['nombre' => 'Alimento Premium 5kg', 'precio_compra' => 60, 'precio_venta' => 90, 'stock' => 8, 'stock_minimo' => 3],
            ['nombre' => 'Shampoo veterinario', 'precio_compra' => 15, 'precio_venta' => 28, 'stock' => 20, 'stock_minimo' => 5],
            ['nombre' => 'Vitaminas', 'precio_compra' => 12, 'precio_venta' => 25, 'stock' => 2, 'stock_minimo' => 5],
        ];
        foreach ($productos as $p) {
            Producto::firstOrCreate(['nombre' => $p['nombre']], array_merge($p, ['categoria_id' => $cat?->id, 'activo' => true]));
        }
    }
}
