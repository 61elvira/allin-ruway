<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrabajadorController;
use App\Http\Controllers\ContratacionController;

Route::get('/', function () {
    return view('casa');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

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


Route::get(
    '/trabajadores/{id}',
    [TrabajadorController::class, 'show']
)->name('trabajadores.show');
Route::get('/trabajadores', function () {
    return view('trabajadores.index');
})->name('trabajadores.index');


Route::get('/contrataciones/crear/{trabajador}', [ContratacionController::class, 'create'])
    ->middleware('auth')
    ->name('contrataciones.create');


Route::get(
    '/contrataciones/crear/{trabajador}',
    [ContratacionController::class, 'create']
)->name('contrataciones.create');

Route::post(
    '/contrataciones',
    [ContratacionController::class, 'store']
)->name('contrataciones.store');

Route::get(
    '/contrataciones',
    [ContratacionController::class, 'index']
)
    ->middleware('auth')
    ->name('contrataciones.index');

Route::patch(
    '/contrataciones/{contratacion}/aceptar',
    [ContratacionController::class, 'aceptar']
)->name('contrataciones.aceptar');

Route::patch(
    '/contrataciones/{contratacion}/rechazar',
    [ContratacionController::class, 'rechazar']
)->name('contrataciones.rechazar');