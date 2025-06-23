<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Configuracion;
use App\Models\Gestion;
use App\Models\Nivel;
use App\Models\Turno;
use App\Models\Periodo;
use App\Models\Grado;
use App\Models\Paralelo;
use App\Models\Materia;
use App\Models\Personal;
use App\Models\Estudiante;
use App\Models\Tutor;

use Faker\Factory as Faker;

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
            'nombre' => 'Primaria',
            'descripcion' => 'Este es el primer nivel de educación',
        ]);
        Nivel::create([
            'nombre' => 'Secundaria',
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

        Periodo::create([
            'nombre' => 'Periodo 1',
            'descripcion' => 'Este es el primer periodo del año',
            'gestion_id' => Gestion::where('nombre', '2024')->first()->id,
        ]);
        Periodo::create([
            'nombre' => 'Periodo 2',
            'descripcion' => 'Este es el segundo periodo del año',
            'gestion_id' => Gestion::where('nombre', '2024')->first()->id,
        ]);

        Grado::create([
            'nombre' => 'Primero',
            'descripcion' => 'Primero Grado',
            'nivel_id' => Nivel::where('nombre', 'Primaria')->first()->id,
        ]);
        Grado::create([
            'nombre' => 'Segundo',
            'descripcion' => 'Segundo Grado',
            'nivel_id' => Nivel::where('nombre', 'Primaria')->first()->id,
        ]);

        Paralelo::create([
            'nombre' => 'A',
            'descripcion' => 'Paralelo A',
            'grado_id' => Grado::where('nombre', 'Primero')->first()->id,
        ]);
        Paralelo::create([
            'nombre' => 'B',
            'descripcion' => 'Paralelo B',
            'grado_id' => Grado::where('nombre', 'Primero')->first()->id,
        ]);

        Paralelo::create([
            'nombre' => 'A',
            'descripcion' => 'Paralelo A',
            'grado_id' => Grado::where('nombre', 'Segundo')->first()->id,
        ]);
        Paralelo::create([
            'nombre' => 'B',
            'descripcion' => 'Paralelo B',
            'grado_id' => Grado::where('nombre', 'Segundo')->first()->id,
        ]);

        Materia::create([
            'nombre' => 'Matemáticas',
            'descripcion' => 'Materia de matemáticas',
        ]);
        Materia::create([
            'nombre' => 'Lengua',
            'descripcion' => 'Materia de lengua',
        ]);
        Materia::create([
            'nombre' => 'Ciencias Naturales',
            'descripcion' => 'Materia de ciencias naturales',
        ]);
        Materia::create([
            'nombre' => 'Historia',
            'descripcion' => 'Materia de historia',
        ]);
        Materia::create([
            'nombre' => 'Geografía',
            'descripcion' => 'Materia de geografía',
        ]);

        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            // Crear un usuario
            $user = User::factory()->create();

            // Crear un personal asociado con el usuario
            Personal::create([
                'nombre' => $faker->firstName(),
                'ap_paterno' => $faker->lastName(),
                'ap_materno' => $faker->lastName(),
                'ci' => $faker->unique()->randomNumber(9),
                'fecha_nacimiento' => $faker->date('Y-m-d'),
                'direccion' => $faker->address,
                'telefono' => $faker->phoneNumber(),
                'correo_electronico' => $faker->unique()->safeEmail,
                'cargo' => 'docente', //$faker->jobTitle(),
                'user_id' => $user->id, // Asociar con el usuario creado
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            // Crear un usuario

            // Crear un personal asociado con el usuario
            Estudiante::create([
                'nombre' => $faker->firstName(),
                'ap_paterno' => $faker->lastName(),
                'ap_materno' => $faker->lastName(),
                'ci' => $faker->unique()->randomNumber(9),
                'fecha_nacimiento' => $faker->date('Y-m-d'),
                'direccion' => $faker->address,
                'telefono' => $faker->phoneNumber(),
                'correo_electronico' => $faker->unique()->safeEmail,
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            // Crear un usuario

            // Crear un personal asociado con el usuario
            Tutor::create([
                'nombre' => $faker->firstName(),
                'ap_paterno' => $faker->lastName(),
                'ap_materno' => $faker->lastName(),
                'ci' => $faker->unique()->randomNumber(9),
                'fecha_nacimiento' => $faker->date('Y-m-d'),
                'direccion' => $faker->address,
                'telefono' => $faker->phoneNumber(),
                'correo_electronico' => $faker->unique()->safeEmail,
            ]);
        }
    }
}
