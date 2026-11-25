<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id', 'nombre', 'descripcion', 'dosis', 'frecuencia', 'duracion',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
