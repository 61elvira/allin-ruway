<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Servicio;
use Illuminate\Http\Request;

class UsuarioController extends Controller
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
                  ->orWhere('especialidad', 'like', "%{$texto}%");
            });
        }

        if ($request->filled('servicio')) {
            $servicio = Servicio::find($request->servicio);
            if ($servicio) {
                $query->where('especialidad', $servicio->nombre);
            }
        }

        if ($request->filled('distrito')) {
            $query->where('distrito', $request->distrito);
        }

        if ($request->filled('experiencia')) {
            $query->where('experiencia', $request->experiencia);
        }

        $filtrosActivos = $request->filled('buscar') || $request->filled('servicio')
            || $request->filled('distrito') || $request->filled('experiencia');

        $trabajadores = $query->latest()->paginate(12)->withQueryString();

        return view('usuarios.index', compact(
            'trabajadores', 'servicios', 'filtrosActivos'
        ));
    }
}
