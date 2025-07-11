<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function grados()
    {
        return $this->hasMany(Grado::class);
    }
}
