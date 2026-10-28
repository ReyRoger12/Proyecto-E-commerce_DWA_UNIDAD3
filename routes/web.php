<?php

use App\Enums\UserRole;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\DashboardRedirectController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('/quienes-somos', 'publica.nosotros')->name('nosotros');
Route::view('/contacto', 'publica.contacto')->name('contacto');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardRedirectController::class)->name('dashboard');

    Route::view('/cliente/dashboard', 'dashboards.cliente')
        ->middleware('role:'.UserRole::Client->value)
        ->name('cliente.dashboard');

    Route::view('/administrador/dashboard', 'dashboards.administrador')
        ->middleware('role:'.UserRole::Administrator->value)
        ->name('administrador.dashboard');

    Route::view('/gerente/dashboard', 'dashboards.gerente')
        ->middleware('role:'.UserRole::Manager->value)
        ->name('gerente.dashboard');

    Route::resource('productos', ProductoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('usuarios', UsuarioController::class);
});

require __DIR__.'/auth.php';

