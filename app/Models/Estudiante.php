<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $table = 'estudiantes';

    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'ci',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'correo_electronico'
    ];

    public function tutores()
    {
        return $this->belongsToMany(Tutor::class, 'estudiante_tutor');
    }

    public function getNombreCompletoAttribute()
    {
        return $this->ap_paterno . ' ' . $this->ap_materno . ', ' . $this->nombre;
    }
}
