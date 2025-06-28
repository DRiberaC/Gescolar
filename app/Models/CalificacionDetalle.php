<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionDetalle extends Model
{
    protected $table = 'calificacion_detalles';

    protected $fillable = [
        'nota',
        'calificacion_id',
        'estudiante_id'
    ];

    public function calificacion()
    {
        return $this->belongsTo(Calificacion::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
