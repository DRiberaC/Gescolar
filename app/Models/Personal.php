<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';

    protected $fillable = [
        'nombre',
        'ap_paterno',
        'ap_materno',
        'ci',
        'fecha_nacimiento',
        'direccion',
        'telefono',
        'correo_electronico',
        'cargo',

        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
