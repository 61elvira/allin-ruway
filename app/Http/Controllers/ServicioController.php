<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::withCount(['contrataciones'])->get();
        $totalTrabajadores = User::where('rol', 'trabajador')->count();

        $serviciosConTrabajadores = $servicios->map(function ($servicio) {
            $servicio->trabajadores_count = User::where('rol', 'trabajador')
                ->where('especialidad', $servicio->nombre)
                ->count();
            return $servicio;
        });

        return view('servicios.index', compact('serviciosConTrabajadores', 'totalTrabajadores'));
    }
}
