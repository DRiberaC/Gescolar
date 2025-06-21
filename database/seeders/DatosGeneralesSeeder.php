<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Configuracion;
use App\Models\Gestion;
use App\Models\Nivel;
use App\Models\Turno;

class DatosGeneralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => bcrypt('password'),
        ]);

        Configuracion::create([
            'nombre' => 'Gescolar',
            'descripcion' => 'Este es un sistema de gestión escolar',
            'direccion' => 'Calle Principal, Ciudad, País',
            'telefono' => '1234567890',
            'correo_electronico' => 'admin@mail.com',
        ]);

        Gestion::create([
            'nombre' => '2024'
        ]);
        Gestion::create([
            'nombre' => '2025'
        ]);

        Nivel::create([
            'nombre' => 'Primer Grado',
            'descripcion' => 'Este es el primer nivel de educación',
        ]);
        Nivel::create([
            'nombre' => 'Segundo Grado',
            'descripcion' => 'Este es el segundo nivel de educación',
        ]);

        Turno::create([
            'nombre' => 'Matutino',
            'descripcion' => 'Turno matutino',
        ]);
        Turno::create([
            'nombre' => 'Vespertino',
            'descripcion' => 'Turno vespertino',
        ]);
    }
}
