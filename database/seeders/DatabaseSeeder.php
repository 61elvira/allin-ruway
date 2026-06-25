<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // <-- IMPORTANTE: Agrega esta línea

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'apellido' => 'User',
            'email' => 'test@example.com',
        ]);

        // <-- Agrega tu código aquí abajo
        DB::table('servicios')->insert([
            [
                'nombre' => 'Carpintería',
                'descripcion' => 'Trabajos en madera'
            ],
            [
                'nombre' => 'Electricidad',
                'descripcion' => 'Instalaciones eléctricas'
            ],
            [
                'nombre' => 'Albañilería',
                'descripcion' => 'Construcción y remodelación'
            ],
            [
                'nombre' => 'Pintura',
                'descripcion' => 'Pintado de interiores y exteriores'
            ]
        ]);
    }
}
