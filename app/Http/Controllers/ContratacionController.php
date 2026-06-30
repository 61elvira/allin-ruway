<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Servicio;
use Illuminate\Http\Request;
use App\Models\Contratacion;

class ContratacionController extends Controller
{
    //
    public function index()
    {
        $contrataciones = Contratacion::with([
            'cliente',
            'servicio'
        ])
            ->where('trabajador_id', auth()->id())
            ->where('estado', 'pendiente')
            ->latest()
            ->get();

        return view(
            'contrataciones.index',
            compact('contrataciones')
        );
    }
    public function misTrabajos()
    {
        $contrataciones = Contratacion::with([
            'cliente',
            'servicio'
        ])
            ->where('trabajador_id', auth()->id())
            ->where('estado', 'aceptado')
            ->latest()
            ->get();

        return view(
            'contrataciones.mis-trabajos',
            compact('contrataciones')
        );
    }
    public function historial()
    {
        $contrataciones = Contratacion::with([
            'cliente',
            'servicio'
        ])
            ->where('trabajador_id', auth()->id())
            ->where('estado', 'finalizado')
            ->latest()
            ->get();

        return view(
            'contrataciones.historial',
            compact('contrataciones')
        );
    }
    public function misContrataciones()
    {
        $contrataciones = Contratacion::with([
            'trabajador',
            'servicio',
            'calificacion'
        ])
            ->where('cliente_id', auth()->id())
            ->latest()
            ->get();

        return view(
            'contrataciones.mis-contrataciones',
            compact('contrataciones')
        );
    }

    public function create(User $trabajador)
    {
        $servicios = Servicio::all();

        return view('contrataciones.create', compact('trabajador', 'servicios'));
    }
    public function store(Request $request)
    {
        Contratacion::create([
            'cliente_id' => auth()->id(),
            'trabajador_id' => $request->trabajador_id,
            'servicio_id' => $request->servicio_id,
            'fecha' => $request->fecha,
            'direccion' => $request->direccion,
            'descripcion' => $request->descripcion,
            'estado' => 'pendiente',
        ]);


        return redirect()->route('dashboard')->with('success', 'Solicitud enviada');
    }
    public function aceptar(Contratacion $contratacion)
    {
        $contratacion->estado = 'aceptado';
        $contratacion->save();

        return back()->with('success', 'Solicitud aceptada correctamente.');
    }

    public function rechazar(Contratacion $contratacion)
    {
        $contratacion->estado = 'rechazado';
        $contratacion->save();

        return back()->with('success', 'Solicitud rechazada.');
    }
    public function finalizar(Contratacion $contratacion)
    {
        $contratacion->estado = 'finalizado';

        $contratacion->save();

        return redirect()
            ->route('contrataciones.misTrabajos')
            ->with(
                'success',
                'Trabajo finalizado correctamente.'
            );
    }
}
