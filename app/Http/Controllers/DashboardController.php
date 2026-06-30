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

        /*
        |--------------------------------------------------------------------------
        | BUSCADOR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('buscar')) {

            $texto = $request->buscar;

            $query->where(function ($q) use ($texto) {

                $q->where('name', 'like', "%{$texto}%")
                    ->orWhere('apellido', 'like', "%{$texto}%")
                    ->orWhere('especialidad', 'like', "%{$texto}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO ESPECIALIDAD
        |--------------------------------------------------------------------------
        */

        if ($request->filled('especialidad')) {

            $query->where('especialidad', $request->especialidad);

        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO DISTRITO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('distrito')) {

            $query->where('distrito', $request->distrito);

        }

        /*
        |--------------------------------------------------------------------------
        | FILTRO EXPERIENCIA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('experiencia')) {

            $query->where('experiencia', $request->experiencia);

        }

        $filtrosActivos =
            $request->filled('buscar') ||
            $request->filled('especialidad') ||
            $request->filled('distrito') ||
            $request->filled('experiencia');

        $trabajadores = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('dashboard.index', compact(
            'servicios',
            'trabajadores',
            'filtrosActivos'
        ));
    }
}