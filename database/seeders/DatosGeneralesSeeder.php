<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Configuracion;

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
    }
}
