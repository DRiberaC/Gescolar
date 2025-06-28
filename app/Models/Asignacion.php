<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'docente_id',
        'gestion_id',
        'materia_id',
        'curso_id',
        'estado',
        'fecha',
        'descripcion',
    ];

    public function docente()
    {
        return $this->belongsTo(Personal::class, 'docente_id', 'id');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class);
    }
}
