<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{

    protected $table = 'cursos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'gestion_id',
        'nivel_id',
        'grado_id',
        'paralelo_id',
        'turno_id'
    ];

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

    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
}
