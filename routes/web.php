<?php

use App\Enums\UserRole;
use App\Http\Controllers\DashboardRedirectController;
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

    Route::view('/empleado/dashboard', 'dashboards.empleado')
        ->middleware('role:'.UserRole::Employee->value)
        ->name('empleado.dashboard');

    Route::view('/gerente/dashboard', 'dashboards.gerente')
        ->middleware('role:'.UserRole::Manager->value)
        ->name('gerente.dashboard');
});

require __DIR__.'/auth.php';
