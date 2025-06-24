<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';

    protected $fillable = [
        'monto',
        'metodo',
        'fecha',
        'descripcion',
        'estado',
        'matricula_id',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }
}
