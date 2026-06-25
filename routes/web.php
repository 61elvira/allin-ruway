<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrabajadorController;

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