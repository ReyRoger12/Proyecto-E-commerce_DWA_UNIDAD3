<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Events\VentaCreada;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(Request $request): View
    {
        Gate::authorize('viewAny', Venta::class);

        $ventas = Venta::query()
            ->with(['producto', 'cliente', 'vendedor'])
            ->latest('fecha')
            ->latest('id')
            ->get()
            ->filter(fn (Venta $venta) => Gate::forUser($request->user())->allows('view', $venta))
            ->values();

        return view('ventas.index', compact('ventas'));
    }

    public function create(Request $request): View
    {
        Gate::authorize('create', Venta::class);

        return view('ventas.create', $this->datosFormulario($request->user()));
    }

    public function store(StoreVentaRequest $request): RedirectResponse
    {
        $venta = Venta::create($request->validated());

        VentaCreada::dispatch($venta);

        return to_route('ventas.show', $venta)
            ->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta): View
    {
        Gate::authorize('view', $venta);

        $venta->load(['producto', 'cliente', 'vendedor']);

        return view('ventas.show', compact('venta'));
    }

    public function edit(Request $request, Venta $venta): View
    {
        Gate::authorize('update', $venta);

        return view('ventas.edit', [
            'venta' => $venta,
            ...$this->datosFormulario($request->user()),
        ]);
    }

    public function update(UpdateVentaRequest $request, Venta $venta): RedirectResponse
    {
        $venta->update($request->validated());

        return to_route('ventas.show', $venta)
            ->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta): RedirectResponse
    {
        Gate::authorize('delete', $venta);

        $venta->delete();

        return to_route('ventas.index')
            ->with('success', 'Venta eliminada correctamente.');
    }

    private function datosFormulario(Usuario $usuario): array
    {
        return [
            'productos' => Producto::query()
                ->with('vendedor')
                ->orderBy('nombre')
                ->get(),
            'usuarios' => Usuario::query()
                ->when(
                    $usuario->rol === UserRole::Client,
                    fn ($consulta) => $consulta->whereKey($usuario->id),
                    fn ($consulta) => $consulta->where('rol', UserRole::Client->value),
                )
                ->orderBy('nombre')
                ->orderBy('apellidos')
                ->get(),
        ];
    }
}
