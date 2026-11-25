<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'tipo', 'descripcion', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}
