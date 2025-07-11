<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $table = 'configuraciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'direccion',
        'telefono',
        'correo_electronico',
        'gestion_id',
    ];

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }
}
