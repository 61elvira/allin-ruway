<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Contratacion;
use App\Models\Calificacion;
use App\Models\Servicio;
use App\Models\Ganancia;
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

        $contratacionesDelAno = Contratacion::whereYear('created_at', date('Y'))
            ->get(['created_at']);
        $contratacionesPorMes = [];
        foreach ($contratacionesDelAno as $c) {
            $m = $c->created_at->month;
            $contratacionesPorMes[$m] = ($contratacionesPorMes[$m] ?? 0) + 1;
        }

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

        $gananciasDelAno = Ganancia::where('estado', 'pagado')
            ->whereYear('fecha_pago', date('Y'))
            ->get(['fecha_pago', 'monto']);
        $ingresosPorMes = [];
        foreach ($gananciasDelAno as $g) {
            $m = $g->fecha_pago instanceof \Carbon\Carbon
                ? $g->fecha_pago->month
                : \Carbon\Carbon::parse($g->fecha_pago)->month;
            $ingresosPorMes[$m] = (float)($ingresosPorMes[$m] ?? 0) + (float)$g->monto;
        }

        $datosIngresos = [];
        for ($i = 1; $i <= 12; $i++) {
            $datosIngresos[] = (float)($ingresosPorMes[$i] ?? 0);
        }

        $topTrabajadores = User::where('rol', User::ROL_TRABAJADOR)
            ->whereHas('calificaciones')
            ->withAvg('calificaciones', 'puntuacion')
            ->orderByDesc('calificaciones_avg_puntuacion')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsuarios', 'totalClientes', 'totalTrabajadores', 'totalAdmins',
            'totalContrataciones', 'contratacionesPendientes', 'contratacionesActivas',
            'contratacionesFinalizadas', 'totalResenas', 'promedioGeneral', 'totalServicios',
            'ultimosUsuarios', 'ultimasContrataciones',
            'meses', 'datosContratos',
            'contratacionesPorEstado', 'usuariosPorRol',
            'distritosPopulares', 'datosIngresos',
            'topTrabajadores'
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

    public function usuariosUpdate(Request $request, User $user)
    {
        $validated = $request->validate([
            'rol' => 'required|in:admin,trabajador,cliente',
        ]);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes cambiar tu propio rol.');
        }

        $user->update($validated);
        return redirect()->route('admin.usuarios')->with('success', 'Rol de usuario actualizado.');
    }

    public function usuariosDestroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();
        return redirect()->route('admin.usuarios')->with('success', 'Usuario eliminado correctamente.');
    }

    public function contrataciones(Request $request)
    {
        $query = Contratacion::with('cliente', 'trabajador', 'servicio');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        $contrataciones = $query->latest()->paginate(15);

        return view('admin.contrataciones', compact('contrataciones'));
    }

    public function contratacionesShow(Contratacion $contratacion)
    {
        $contratacion->load('cliente', 'trabajador', 'servicio', 'calificacion');
        return view('admin.contrataciones-show', compact('contratacion'));
    }

    public function contratacionesUpdateEstado(Request $request, Contratacion $contratacion)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,aceptado,rechazado,finalizado',
        ]);

        $contratacion->update($validated);
        return redirect()->route('admin.contrataciones.show', $contratacion)
            ->with('success', 'Estado actualizado a ' . $validated['estado'] . '.');
    }

    public function servicios()
    {
        $servicios = Servicio::withCount('contrataciones')->get();
        return view('admin.servicios', compact('servicios'));
    }

    public function serviciosStore(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        Servicio::create($validated);
        return redirect()->route('admin.servicios')->with('success', 'Servicio creado correctamente.');
    }

    public function serviciosUpdate(Request $request, Servicio $servicio)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $servicio->update($validated);
        return redirect()->route('admin.servicios')->with('success', 'Servicio actualizado correctamente.');
    }

    public function serviciosDestroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('admin.servicios')->with('success', 'Servicio eliminado correctamente.');
    }

    public function exportarUsuarios(Request $request)
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

        $usuarios = $query->latest()->get();
        $csv = "ID,Nombre,Apellido,Email,Rol,Distrito,Telefono,Registro\n";

        foreach ($usuarios as $u) {
            $csv .= "\"{$u->id}\",\"{$u->name}\",\"{$u->apellido}\",\"{$u->email}\",\"{$u->rol}\",\"{$u->distrito}\",\"{$u->telefono}\",\"{$u->created_at->format('d/m/Y')}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="usuarios.csv"',
        ]);
    }

    public function exportarContrataciones(Request $request)
    {
        $query = Contratacion::with('cliente', 'trabajador', 'servicio');

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $contrataciones = $query->latest()->get();
        $csv = "ID,Cliente,Trabajador,Servicio,Fecha,Estado,Direccion\n";

        foreach ($contrataciones as $c) {
            $fecha = $c->fecha ? \Carbon\Carbon::parse($c->fecha)->format('d/m/Y') : '';
            $csv .= "\"{$c->id}\",\"{$c->cliente->name}\",\"{$c->trabajador->name}\",\"{$c->servicio->nombre}\",\"{$fecha}\",\"{$c->estado}\",\"{$c->direccion}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="contrataciones.csv"',
        ]);
    }

    public function exportarServicios()
    {
        $servicios = Servicio::withCount('contrataciones')->get();
        $csv = "ID,Nombre,Descripcion,Contrataciones\n";

        foreach ($servicios as $s) {
            $csv .= "\"{$s->id}\",\"{$s->nombre}\",\"{$s->descripcion}\",\"{$s->contrataciones_count}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="servicios.csv"',
        ]);
    }
}
