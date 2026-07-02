<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Servicio;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@allinruway.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'apellido' => 'Principal',
                'email' => 'admin@allinruway.com',
                'password' => bcrypt('admin123'),
                'rol' => User::ROL_ADMIN,
            ]);
            $this->command->info('Admin creado.');
        }

        if (Servicio::count() === 0) {
            $servicios = [
                ['nombre' => 'Electricista', 'descripcion' => 'Instalaciones eléctricas, mantenimiento y reparación.'],
                ['nombre' => 'Carpintero', 'descripcion' => 'Fabricación y reparación de muebles de madera.'],
                ['nombre' => 'Gasfitero', 'descripcion' => 'Reparación de tuberías, fugas e instalaciones sanitarias.'],
                ['nombre' => 'Pintor', 'descripcion' => 'Pintado de interiores, exteriores y acabados.'],
                ['nombre' => 'Albañil', 'descripcion' => 'Construcción, remodelación y mantenimiento de estructuras.'],
                ['nombre' => 'Jardinero', 'descripcion' => 'Diseño y mantenimiento de jardines y áreas verdes.'],
            ];
            foreach ($servicios as $s) {
                Servicio::create($s);
            }
            $this->command->info(count($servicios) . ' servicios creados.');
        } else {
            $this->command->info('Servicios ya existen.');
        }
    }
}
