<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'asignaciones';

    protected $fillable = [
        'docente_id',
        'gestion_id',
        'nivel_id',
        'grado_id',
        'paralelo_id',
        'materia_id',
        'turno_id',
        'estado',
        'fecha',
    ];

    public function docente()
    {
        return $this->belongsTo(Personal::class, 'docente_id', 'id');
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
}
