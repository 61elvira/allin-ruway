<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $servicios = Servicio::all();

        $query = User::where('rol', 'trabajador');

        if ($request->filled('buscar')) {

            $texto = $request->buscar;

            $query->where(function ($q) use ($texto) {

                $q->where('name', 'like', "%{$texto}%")
                    ->orWhere('apellido', 'like', "%{$texto}%")
                    ->orWhere('especialidad', 'like', "%{$texto}%")
                    ->orWhere('distrito', 'like', "%{$texto}%");

            });

        }

        $trabajadores = $query
            ->latest()
            ->paginate(6);

        return view('dashboard.index', compact(
            'servicios',
            'trabajadores'
        ));
    }
}