<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombres', 'apellidos', 'dni', 'telefono', 'email', 'direccion', 'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
