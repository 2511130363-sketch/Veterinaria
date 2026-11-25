<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mascota extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cliente_id', 'nombre', 'especie', 'raza', 'sexo', 'fecha_nacimiento',
        'peso', 'color', 'foto', 'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'peso' => 'decimal:2',
        'activo' => 'boolean',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }
}
