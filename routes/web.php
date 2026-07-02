<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ContratacionController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', function () {
    return view('casa');
});

Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return app(DashboardController::class)->index();
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

Route::post('/convertirse-trabajador', function () {
    $user = auth()->user();
    $user->rol = 'trabajador';
    $user->save();
    return back()->with('success', 'Ahora eres trabajador');
})->middleware('auth');

Route::get('/trabajadores/{id}', [TrabajadorController::class, 'show'])->name('trabajadores.show');
Route::get('/trabajadores', function () {
    return view('trabajadores.index');
})->name('trabajadores.index');

Route::get('/contrataciones/crear/{trabajador}', [ContratacionController::class, 'create'])
    ->middleware('auth')
    ->name('contrataciones.create');

Route::post('/contrataciones', [ContratacionController::class, 'store'])->name('contrataciones.store');

Route::get('/contrataciones', [ContratacionController::class, 'index'])
    ->middleware('auth')
    ->name('contrataciones.index');

Route::patch('/contrataciones/{contratacion}/aceptar', [ContratacionController::class, 'aceptar'])
    ->name('contrataciones.aceptar');

Route::patch('/contrataciones/{contratacion}/rechazar', [ContratacionController::class, 'rechazar'])
    ->name('contrataciones.rechazar');

Route::get('/mis-trabajos', [ContratacionController::class, 'misTrabajos'])
    ->middleware('auth')
    ->name('contrataciones.misTrabajos');

Route::patch('/contrataciones/{contratacion}/finalizar', [ContratacionController::class, 'finalizar'])
    ->name('contrataciones.finalizar');

Route::get('/historial', [ContratacionController::class, 'historial'])
    ->middleware('auth')
    ->name('contrataciones.historial');

Route::get('/mis-contrataciones', [ContratacionController::class, 'misContrataciones'])
    ->middleware('auth')
    ->name('contrataciones.misContrataciones');

Route::get('/calificaciones/{contratacion}', [CalificacionController::class, 'create'])
    ->name('calificaciones.create');

Route::post('/calificaciones', [CalificacionController::class, 'store'])
    ->name('calificaciones.store');

// ─── Admin Routes ───
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/contrataciones', [AdminController::class, 'contrataciones'])->name('contrataciones');
    Route::get('/servicios', [AdminController::class, 'servicios'])->name('servicios');
});
