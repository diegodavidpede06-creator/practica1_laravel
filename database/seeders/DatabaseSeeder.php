<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Docente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Crear datos iniciales del sistema.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Docente
        |--------------------------------------------------------------------------
        */

        Docente::create([
            'nombre' => 'Docente Principal',
            'usuario' => 'docente',
            'password' => Hash::make('Docente123'),
            'activo' => true,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Alumnos
        |--------------------------------------------------------------------------
        */

        $alumnos = [
            'Ana García López',
            'Carlos Hernández Pérez',
            'Daniela Martínez Ruiz',
            'Eduardo Sánchez Torres',
            'Fernanda González Morales',
            'Gabriel Ramírez Flores',
            'Héctor Jiménez Vargas',
            'Isabella López Castillo',
            'Javier Mendoza Cruz',
            'Karla Rodríguez Silva',
            'Luis Alberto Torres',
            'Mariana Flores Navarro',
            'Nicolás Pérez Gómez',
            'Sofía Ramírez Hernández',
            'Valentina Morales Díaz',
        ];

        foreach ($alumnos as $indice => $nombre) {

            $numero = str_pad(
                $indice + 1,
                2,
                '0',
                STR_PAD_LEFT
            );

            Alumno::create([
                'nombre' => $nombre,
                'usuario' => 'alumno' . $numero,
                'password' => Hash::make('Alumno123'),
                'activo' => true,
            ]);
        }
    }
}