<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('servicios')->insert([
            [
                'nombre' => 'Carpintero',
                'descripcion' => 'Trabajos en madera'
            ],
            [
                'nombre' => 'Electricista',
                'descripcion' => 'Instalaciones, mantenimiento y reparación de sistemas eléctricos.'
            ],
            [
                'nombre' => 'Gasfitero',
                'descripcion' => 'Instalaciones sanitarias'
            ]
        ]);
    }
}