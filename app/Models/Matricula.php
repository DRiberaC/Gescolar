<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    protected $table = 'matriculas';

    protected $fillable = [
        'estudiante_id',
        'gestion_id',
        'periodo_id',
        'nivel_id',
        'grado_id',
        'paralelo_id',
        'fecha'
    ];

    // Relación con el modelo Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Relación con el modelo Gestion
    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    // Relación con el modelo Periodo
    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    // Relación con el modelo Nivel
    public function nivel()
    {
        return $this->belongsTo(Nivel::class);
    }

    // Relación con el modelo Grado
    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    // Relación con el modelo Paralelo (si es nullable)
    public function paralelo()
    {
        return $this->belongsTo(Paralelo::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
