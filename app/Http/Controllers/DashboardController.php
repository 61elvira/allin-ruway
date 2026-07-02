<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\User;
use App\Models\Contratacion;
use App\Models\Calificacion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $servicios = Servicio::all();
        $totalTrabajadores = User::where('rol', 'trabajador')->count();
        $totalServicios = Servicio::count();

        $stats = [];

        if ($user->isTrabajador()) {
            $contrataciones = Contratacion::where('trabajador_id', $user->id);
            $stats['total_solicitudes'] = (clone $contrataciones)->count();
            $stats['pendientes'] = (clone $contrataciones)->where('estado', 'pendiente')->count();
            $stats['activas'] = (clone $contrataciones)->where('estado', 'aceptado')->count();
            $stats['finalizadas'] = (clone $contrataciones)->where('estado', 'finalizado')->count();
            $stats['promedio'] = Calificacion::where('trabajador_id', $user->id)->avg('puntuacion');
            $stats['total_resenas'] = Calificacion::where('trabajador_id', $user->id)->count();
        } elseif ($user->isCliente()) {
            $contrataciones = Contratacion::where('cliente_id', $user->id);
            $stats['total_contrataciones'] = (clone $contrataciones)->count();
            $stats['pendientes'] = (clone $contrataciones)->where('estado', 'pendiente')->count();
            $stats['activas'] = (clone $contrataciones)->where('estado', 'aceptado')->count();
            $stats['finalizadas'] = (clone $contrataciones)->where('estado', 'finalizado')->count();
        }

        $contratacionesPorMes = Contratacion::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes')
            ->toArray();

        $meses = [];
        $datosContratos = [];
        for ($i = 1; $i <= 12; $i++) {
            $meses[] = match($i) {
                1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
                5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
                9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic',
            };
            $datosContratos[] = $contratacionesPorMes[$i] ?? 0;
        }

        return view('dashboard.index', compact(
            'stats', 'servicios', 'totalTrabajadores', 'totalServicios',
            'meses', 'datosContratos'
        ));
    }
}
