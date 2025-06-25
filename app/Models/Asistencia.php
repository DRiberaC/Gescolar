<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencias';

    protected $fillable = [
        'asignacion_id',
        'fecha',
        'descripcion'
    ];

    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class);
    }

    public function detalles()
    {
        return $this->hasMany(AsistenciaDetalle::class);
    }
}
