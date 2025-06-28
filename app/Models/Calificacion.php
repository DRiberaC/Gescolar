<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'tipo',
        'fecha',
        'descripcion',
        'asignacion_id'
    ];

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class);
    }

    public function calificacionDetalles()
    {
        return $this->hasMany(CalificacionDetalle::class);
    }
}
