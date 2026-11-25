<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veterinario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'nombres', 'apellidos', 'especialidad', 'colegiatura',
        'telefono', 'email', 'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
