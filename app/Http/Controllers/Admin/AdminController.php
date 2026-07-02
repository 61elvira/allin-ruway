<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contratacion;
use App\Models\Calificacion;
use App\Models\Servicio;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsuarios = User::count();
        $totalClientes = User::where('rol', User::ROL_CLIENTE)->count();
        $totalTrabajadores = User::where('rol', User::ROL_TRABAJADOR)->count();
        $totalAdmins = User::where('rol', User::ROL_ADMIN)->count();

        $totalContrataciones = Contratacion::count();
        $contratacionesPendientes = Contratacion::where('estado', 'pendiente')->count();
        $contratacionesActivas = Contratacion::where('estado', 'aceptado')->count();
        $contratacionesFinalizadas = Contratacion::where('estado', 'finalizado')->count();

        $totalResenas = Calificacion::count();
        $promedioGeneral = Calificacion::avg('puntuacion');

        $totalServicios = Servicio::count();

        $ultimosUsuarios = User::latest()->take(5)->get();
        $ultimasContrataciones = Contratacion::with('cliente', 'trabajador', 'servicio')
            ->latest()->take(5)->get();

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

        $contratacionesPorEstado = [
            'pendientes' => $contratacionesPendientes,
            'activas' => $contratacionesActivas,
            'finalizadas' => $contratacionesFinalizadas,
        ];

        $usuariosPorRol = [
            'clientes' => $totalClientes,
            'trabajadores' => $totalTrabajadores,
            'admins' => $totalAdmins,
        ];

        $distritosPopulares = User::where('rol', User::ROL_TRABAJADOR)
            ->whereNotNull('distrito')
            ->selectRaw('distrito, COUNT(*) as total')
            ->groupBy('distrito')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'distrito')
            ->toArray();

        return view('admin.dashboard', compact(
            'totalUsuarios', 'totalClientes', 'totalTrabajadores', 'totalAdmins',
            'totalContrataciones', 'contratacionesPendientes', 'contratacionesActivas',
            'contratacionesFinalizadas', 'totalResenas', 'promedioGeneral', 'totalServicios',
            'ultimosUsuarios', 'ultimasContrataciones',
            'meses', 'datosContratos',
            'contratacionesPorEstado', 'usuariosPorRol',
            'distritosPopulares'
        ));
    }

    public function usuarios(Request $request)
    {
        $query = User::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('name', 'like', "%{$buscar}%")
                  ->orWhere('apellido', 'like', "%{$buscar}%")
                  ->orWhere('email', 'like', "%{$buscar}%");
            });
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        $usuarios = $query->latest()->paginate(15);

        return view('admin.usuarios', compact('usuarios'));
    }

    public function contrataciones(Request $request)
    {
        $query = Contratacion::with('cliente', 'trabajador', 'servicio');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $contrataciones = $query->latest()->paginate(15);

        return view('admin.contrataciones', compact('contrataciones'));
    }

    public function servicios()
    {
        $servicios = Servicio::withCount('contrataciones')->get();
        return view('admin.servicios', compact('servicios'));
    }
}
