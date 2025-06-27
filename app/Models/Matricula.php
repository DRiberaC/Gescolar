<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';

    protected $fillable = [
        'estudiante_id',
        'gestion_id',
        'curso_id',
        'fecha'
    ];

    // Relación con el modelo Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Relación con el modelo Curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    // Relación con el modelo Gestion
    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
