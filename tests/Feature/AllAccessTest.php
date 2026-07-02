<?php

use App\Models\User;
use App\Models\Servicio;
use App\Models\Contratacion;
use App\Models\Calificacion;
use App\Models\Ganancia;
use App\Models\Disponibilidad;
use App\Models\TrabajadorServicio;

// ─── Helpers ───

function createServicios(): void
{
    if (Servicio::count() > 0) return;
    $nombres = ['Electricista', 'Carpintero', 'Gasfitero', 'Pintor', 'Albañil', 'Jardinero'];
    foreach ($nombres as $n) {
        Servicio::create(['nombre' => $n, 'descripcion' => "Servicio de $n"]);
    }
}

function createAdmin(): User
{
    return User::factory()->create([
        'email' => 'admin@test.com',
        'rol' => User::ROL_ADMIN,
        'email_verified_at' => now(),
    ]);
}

function createTrabajador(): User
{
    $t = User::factory()->create([
        'email' => 'trabajador@test.com',
        'rol' => User::ROL_TRABAJADOR,
        'distrito' => 'Miraflores',
        'email_verified_at' => now(),
    ]);
    $servicio = Servicio::first();
    if ($servicio) {
        TrabajadorServicio::create([
            'trabajador_id' => $t->id,
            'servicio_id' => $servicio->id,
            'precio' => 80,
        ]);
        Disponibilidad::create([
            'trabajador_id' => $t->id,
            'dia_semana' => 1,
            'hora_inicio' => '09:00',
            'hora_fin' => '17:00',
            'activo' => true,
        ]);
    }
    return $t;
}

function createCliente(): User
{
    return User::factory()->create([
        'email' => 'cliente@test.com',
        'rol' => User::ROL_CLIENTE,
        'email_verified_at' => now(),
    ]);
}

function createContratacion(User $cliente, User $trabajador, string $estado = 'pendiente'): Contratacion
{
    $c = Contratacion::create([
        'cliente_id' => $cliente->id,
        'trabajador_id' => $trabajador->id,
        'servicio_id' => Servicio::first()->id,
        'fecha' => now()->addDays(3)->format('Y-m-d'),
        'direccion' => 'Av. Test 123',
        'descripcion' => 'Test contratacion',
        'estado' => $estado,
    ]);
    if ($estado === 'finalizado') {
        Calificacion::create([
            'contratacion_id' => $c->id,
            'cliente_id' => $cliente->id,
            'trabajador_id' => $trabajador->id,
            'puntuacion' => 5,
            'comentario' => 'Excelente',
        ]);
        Ganancia::create([
            'trabajador_id' => $trabajador->id,
            'contratacion_id' => $c->id,
            'monto' => 100,
            'concepto' => 'Pago',
            'estado' => 'pagado',
            'fecha_pago' => now(),
        ]);
    }
    return $c;
}

// ═══════════════════════════════════════
//  GUEST ACCESS
// ═══════════════════════════════════════

beforeEach(function () {
    createServicios();
});

describe('guest access', function () {

    it('homepage returns 200', function () {
        $this->get('/')->assertStatus(200);
    });

    it('dashboard redirects to login', function () {
        $this->get('/dashboard')->assertRedirect('/login');
    });

    it('admin routes redirect to login for guests', function () {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/usuarios')->assertRedirect('/login');
        $this->get('/admin/contrataciones')->assertRedirect('/login');
        $this->get('/admin/servicios')->assertRedirect('/login');
    });

    it('trabajador routes redirect to login for guests', function () {
        $this->get('/trabajador/mis-servicios')->assertRedirect('/login');
        $this->get('/trabajador/disponibilidad')->assertRedirect('/login');
        $this->get('/trabajador/ganancias')->assertRedirect('/login');
        $this->get('/trabajador/resenas')->assertRedirect('/login');
    });

    it('protected routes redirect to login', function () {
        $this->get('/contrataciones')->assertRedirect('/login');
        $this->get('/mis-trabajos')->assertRedirect('/login');
        $this->get('/historial')->assertRedirect('/login');
        $this->get('/mis-contrataciones')->assertRedirect('/login');
        $this->get('/trabajadores')->assertRedirect('/login');
    });
});

// ═══════════════════════════════════════
//  ADMIN ACCESS
// ═══════════════════════════════════════

describe('admin', function () {

    beforeEach(function () {
        $this->admin = createAdmin();
        $this->actingAs($this->admin);
    });

    it('dashboard loads with stats', function () {
        $this->get('/admin')
            ->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('Usuarios totales');
    });

    it('usuarios list renders with columns', function () {
        createTrabajador();
        createCliente();
        $this->get('/admin/usuarios')
            ->assertStatus(200)
            ->assertSee('admin')
            ->assertSee('trabajador')
            ->assertSee('cliente');
    });

    it('usuarios filter by rol', function () {
        createTrabajador();
        $this->get('/admin/usuarios?rol=trabajador')
            ->assertStatus(200)
            ->assertSee('trabajador');
    });

    it('usuarios filter by search', function () {
        $this->get('/admin/usuarios?buscar=admin')
            ->assertStatus(200)
            ->assertSee('admin');
    });

    it('usuarios change role', function () {
        $user = createCliente();
        $this->patch("/admin/usuarios/{$user->id}/rol", ['rol' => 'trabajador'])
            ->assertStatus(302);
        expect($user->fresh()->rol)->toBe('trabajador');
    });

    it('usuarios cannot change own role', function () {
        $this->patch("/admin/usuarios/{$this->admin->id}/rol", ['rol' => 'cliente'])
            ->assertStatus(302);
        expect($this->admin->fresh()->rol)->toBe('admin');
    });

    it('usuarios delete', function () {
        $user = createCliente();
        $this->delete("/admin/usuarios/{$user->id}")
            ->assertStatus(302);
        expect(User::find($user->id))->toBeNull();
    });

    it('usuarios cannot delete self', function () {
        $this->delete("/admin/usuarios/{$this->admin->id}")
            ->assertStatus(302);
        expect(User::find($this->admin->id))->not->toBeNull();
    });

    it('usuarios export csv', function () {
        createTrabajador();
        $this->get('/admin/usuarios/exportar')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=utf-8')
            ->assertSee('ID,Nombre,Apellido,Email,Rol');
    });

    it('contrataciones list', function () {
        $cliente = createCliente();
        $trabajador = createTrabajador();
        createContratacion($cliente, $trabajador);
        $this->get('/admin/contrataciones')
            ->assertStatus(200)
            ->assertSee('Pendiente');
    });

    it('contrataciones filter by estado', function () {
        $cliente = createCliente();
        $trabajador = createTrabajador();
        createContratacion($cliente, $trabajador, 'finalizado');
        $this->get('/admin/contrataciones?estado=finalizado')
            ->assertStatus(200)
            ->assertSee('Finalizado');
    });

    it('contrataciones filter by date range', function () {
        $cliente = createCliente();
        $trabajador = createTrabajador();
        createContratacion($cliente, $trabajador);
        $this->get('/admin/contrataciones?fecha_desde=' . now()->addDays(1)->format('Y-m-d') . '&fecha_hasta=' . now()->addDays(5)->format('Y-m-d'))
            ->assertStatus(200);
    });

    it('contrataciones show detail', function () {
        $cliente = createCliente();
        $trabajador = createTrabajador();
        $c = createContratacion($cliente, $trabajador, 'finalizado');
        $this->get("/admin/contrataciones/{$c->id}")
            ->assertStatus(200)
            ->assertSee("#{$c->id}")
            ->assertSee('Finalizado')
            ->assertSee('5');
    });

    it('contrataciones update estado', function () {
        $cliente = createCliente();
        $trabajador = createTrabajador();
        $c = createContratacion($cliente, $trabajador, 'pendiente');
        $this->patch("/admin/contrataciones/{$c->id}/estado", ['estado' => 'aceptado'])
            ->assertStatus(302);
        expect($c->fresh()->estado)->toBe('aceptado');
    });

    it('contrataciones export csv', function () {
        $cliente = createCliente();
        $trabajador = createTrabajador();
        createContratacion($cliente, $trabajador);
        $this->get('/admin/contrataciones/exportar')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=utf-8')
            ->assertSee('ID,Cliente,Trabajador,Servicio,Fecha,Estado,Direccion');
    });

    it('servicios list', function () {
        $this->get('/admin/servicios')
            ->assertStatus(200)
            ->assertSee('Electricista');
    });

    it('servicios create', function () {
        $this->post('/admin/servicios', [
            'nombre' => 'Limpieza',
            'descripcion' => 'Limpieza general',
        ])->assertStatus(302);
        expect(Servicio::where('nombre', 'Limpieza')->exists())->toBeTrue();
    });

    it('servicios update', function () {
        $s = Servicio::first();
        $this->patch("/admin/servicios/{$s->id}", [
            'nombre' => 'Electricista V2',
            'descripcion' => 'Nueva descripcion',
        ])->assertStatus(302);
        expect($s->fresh()->nombre)->toBe('Electricista V2');
    });

    it('servicios delete', function () {
        $s = Servicio::first();
        $this->delete("/admin/servicios/{$s->id}")->assertStatus(302);
        expect(Servicio::find($s->id))->toBeNull();
    });

    it('servicios export csv', function () {
        $this->get('/admin/servicios/exportar')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=utf-8')
            ->assertSee('ID,Nombre,Descripcion,Contrataciones');
    });

    it('dashboard redirects to admin', function () {
        $this->get('/dashboard')->assertRedirect('/admin');
    });
});

// ═══════════════════════════════════════
//  TRABAJADOR ACCESS
// ═══════════════════════════════════════

describe('trabajador', function () {

    beforeEach(function () {
        $this->trabajador = createTrabajador();
        $this->actingAs($this->trabajador);
    });

    it('dashboard loads', function () {
        $this->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Dashboard');
    });

    it('mis-servicios list', function () {
        $this->get('/trabajador/mis-servicios')
            ->assertStatus(200);
    });

    it('mis-servicios store', function () {
        $servicio = Servicio::where('id', '!=', $this->trabajador->serviciosOfrecidos()->first()?->servicio_id)->first();
        if (!$servicio) return;
        $this->post('/trabajador/mis-servicios', [
            'servicio_id' => $servicio->id,
            'precio' => 150,
        ])->assertStatus(302);
        expect(TrabajadorServicio::where('trabajador_id', $this->trabajador->id)
            ->where('servicio_id', $servicio->id)->exists())->toBeTrue();
    });

    it('mis-servicios update', function () {
        $ts = $this->trabajador->serviciosOfrecidos()->first();
        if (!$ts) return;
        $this->patch("/trabajador/mis-servicios/{$ts->id}", ['precio' => 200])
            ->assertStatus(302);
        expect($ts->fresh()->precio)->toBe(200);
    });

    it('mis-servicios delete', function () {
        $ts = $this->trabajador->serviciosOfrecidos()->first();
        if (!$ts) return;
        $this->delete("/trabajador/mis-servicios/{$ts->id}")->assertStatus(302);
        expect(TrabajadorServicio::find($ts->id))->toBeNull();
    });

    it('disponibilidad list', function () {
        $this->get('/trabajador/disponibilidad')
            ->assertStatus(200);
    });

    it('disponibilidad store', function () {
        $this->post('/trabajador/disponibilidad', [
            'dia_semana' => 3,
            'hora_inicio' => '10:00',
            'hora_fin' => '14:00',
        ])->assertStatus(302);
        expect(Disponibilidad::where('trabajador_id', $this->trabajador->id)
            ->where('dia_semana', 3)->exists())->toBeTrue();
    });

    it('disponibilidad toggle', function () {
        $d = $this->trabajador->disponibilidades()->first();
        if (!$d) return;
        $original = $d->activo;
        $this->patch("/trabajador/disponibilidad/{$d->id}/toggle")->assertStatus(302);
        expect($d->fresh()->activo)->toBe(!$original);
    });

    it('disponibilidad delete', function () {
        $d = $this->trabajador->disponibilidades()->first();
        if (!$d) return;
        $this->delete("/trabajador/disponibilidad/{$d->id}")->assertStatus(302);
        expect(Disponibilidad::find($d->id))->toBeNull();
    });

    it('solicitudes list', function () {
        $cliente = createCliente();
        createContratacion($cliente, $this->trabajador, 'pendiente');
        $this->get('/contrataciones')
            ->assertStatus(200)
            ->assertSee('Pendiente');
    });

    it('mis-trabajos list', function () {
        $cliente = createCliente();
        createContratacion($cliente, $this->trabajador, 'aceptado');
        $this->get('/mis-trabajos')
            ->assertStatus(200)
            ->assertSee('Aceptado');
    });

    it('aceptar contratacion', function () {
        $cliente = createCliente();
        $c = createContratacion($cliente, $this->trabajador, 'pendiente');
        $this->patch("/contrataciones/{$c->id}/aceptar")->assertStatus(302);
        expect($c->fresh()->estado)->toBe('aceptado');
    });

    it('rechazar contratacion', function () {
        $cliente = createCliente();
        $c = createContratacion($cliente, $this->trabajador, 'pendiente');
        $this->patch("/contrataciones/{$c->id}/rechazar")->assertStatus(302);
        expect($c->fresh()->estado)->toBe('rechazado');
    });

    it('finalizar contratacion', function () {
        $cliente = createCliente();
        $c = createContratacion($cliente, $this->trabajador, 'aceptado');
        $this->patch("/contrataciones/{$c->id}/finalizar")->assertStatus(302);
        expect($c->fresh()->estado)->toBe('finalizado');
    });

    it('ganancias list', function () {
        $cliente = createCliente();
        createContratacion($cliente, $this->trabajador, 'finalizado');
        $this->get('/trabajador/ganancias')
            ->assertStatus(200);
    });

    it('resenas list', function () {
        $cliente = createCliente();
        createContratacion($cliente, $this->trabajador, 'finalizado');
        $this->get('/trabajador/resenas')
            ->assertStatus(200);
    });

    it('historial list', function () {
        $cliente = createCliente();
        createContratacion($cliente, $this->trabajador, 'finalizado');
        $this->get('/historial')
            ->assertStatus(200);
    });

    it('admin routes return 403', function () {
        $this->get('/admin')->assertStatus(403);
        $this->get('/admin/usuarios')->assertStatus(403);
        $this->get('/admin/servicios')->assertStatus(403);
    });
});

// ═══════════════════════════════════════
//  CLIENTE ACCESS
// ═══════════════════════════════════════

describe('cliente', function () {

    beforeEach(function () {
        $this->cliente = createCliente();
        $this->trabajador = createTrabajador();
        $this->actingAs($this->cliente);
    });

    it('dashboard loads', function () {
        $this->get('/dashboard')
            ->assertStatus(200)
            ->assertSee('Dashboard');
    });

    it('trabajadores list', function () {
        $this->get('/trabajadores')
            ->assertStatus(200)
            ->assertSee('Miraflores');
    });

    it('trabajador show page', function () {
        $this->get("/trabajadores/{$this->trabajador->id}")
            ->assertStatus(200)
            ->assertSee($this->trabajador->name);
    });

    it('contratacion create form', function () {
        $this->get("/contrataciones/crear/{$this->trabajador->id}")
            ->assertStatus(200);
    });

    it('contratacion store', function () {
        $servicio = Servicio::first();
        $this->post('/contrataciones', [
            'trabajador_id' => $this->trabajador->id,
            'servicio_id' => $servicio->id,
            'fecha' => now()->addDays(5)->format('Y-m-d'),
            'direccion' => 'Av. Test 456',
            'descripcion' => 'Necesito ayuda',
        ])->assertStatus(302);
        expect(Contratacion::where('cliente_id', $this->cliente->id)->exists())->toBeTrue();
    });

    it('mis-contrataciones list', function () {
        createContratacion($this->cliente, $this->trabajador);
        $this->get('/mis-contrataciones')
            ->assertStatus(200);
    });

    it('calificacion create form', function () {
        $c = createContratacion($this->cliente, $this->trabajador, 'finalizado');
        $this->get("/calificaciones/{$c->id}")
            ->assertStatus(200);
    });

    it('calificacion store', function () {
        $c = createContratacion($this->cliente, $this->trabajador, 'finalizado');
        $this->post('/calificaciones', [
            'contratacion_id' => $c->id,
            'trabajador_id' => $this->trabajador->id,
            'puntuacion' => 4,
            'comentario' => 'Buen trabajo',
        ])->assertStatus(302);
        expect(Calificacion::where('contratacion_id', $c->id)->exists())->toBeTrue();
    });

    it('admin routes return 403', function () {
        $this->get('/admin')->assertStatus(403);
    });

    it('trabajador-specific routes return 403', function () {
        $this->get('/trabajador/mis-servicios')->assertStatus(403);
        $this->get('/trabajador/disponibilidad')->assertStatus(403);
        $this->get('/trabajador/ganancias')->assertStatus(403);
        $this->get('/trabajador/resenas')->assertStatus(403);
    });
});
