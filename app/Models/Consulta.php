<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'mascota_id', 'veterinario_id', 'cita_id', 'fecha', 'sintomas', 'diagnostico',
        'tratamiento', 'observaciones', 'peso', 'temperatura',
    ];

    protected $casts = [
        'fecha' => 'date',
        'peso' => 'decimal:2',
        'temperatura' => 'decimal:2',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class);
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    public function tratamientos()
    {
        return $this->hasMany(Tratamiento::class);
    }
}
