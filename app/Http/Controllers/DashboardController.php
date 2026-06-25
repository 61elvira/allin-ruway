<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $servicios = Servicio::all();

        $trabajadores = User::where('rol', 'trabajador')
            ->take(6)
            ->get();

        return view('dashboard.index', compact(
            'servicios',
            'trabajadores'
        ));
    }
}