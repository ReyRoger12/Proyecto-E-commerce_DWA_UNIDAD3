<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Producto::class);

        $productos = Producto::query()
            ->with(['vendedor', 'categorias'])
            ->latest()
            ->paginate(12);

        return view('productos.index', compact('productos'));
    }

    public function create(): View
    {
        Gate::authorize('create', Producto::class);

        return view('productos.create', [
            'categorias' => Categoria::query()->orderBy('nombre')->get(),
            'vendedores' => Usuario::query()
                ->whereIn('rol', ['administrador', 'gerente'])
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function store(StoreProductoRequest $request): RedirectResponse
    {
        $datos = $request->validated();

        $producto = DB::transaction(function () use ($datos): Producto {
            $categorias = $datos['categorias'];
            unset($datos['categorias']);

            $producto = Producto::create($datos);
            $producto->categorias()->sync($categorias);

            return $producto;
        });

        Log::channel('productos')->info('Producto creado', [
            'producto_id' => $producto->id,
            'usuario_id' => $request->user()->id,
            'ip' => $request->ip(),
        ]);

        return to_route('productos.index')
            ->with('success', 'Producto registrado correctamente.');
    }

    public function show(Producto $producto): View
    {
        Gate::authorize('view', $producto);

        $producto->load(['vendedor', 'categorias']);

        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto): View
    {
        Gate::authorize('update', $producto);

        $producto->load('categorias');

        return view('productos.edit', [
            'producto' => $producto,
            'categorias' => Categoria::query()->orderBy('nombre')->get(),
            'vendedores' => Usuario::query()
                ->whereIn('rol', ['administrador', 'gerente'])
                ->orderBy('nombre')
                ->get(),
        ]);
    }

    public function update(UpdateProductoRequest $request, Producto $producto): RedirectResponse
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos, $producto): void {
            $categorias = $datos['categorias'];
            unset($datos['categorias']);

            $producto->update($datos);
            $producto->categorias()->sync($categorias);
        });

        Log::channel('productos')->info('Producto actualizado', [
            'producto_id' => $producto->id,
            'usuario_id' => $request->user()->id,
            'ip' => $request->ip(),
        ]);

        return to_route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Request $request, Producto $producto): RedirectResponse
    {
        Gate::authorize('delete', $producto);

        if ($producto->ventas()->exists()) {
            return to_route('productos.index')
                ->with('error', 'No se puede eliminar el producto porque tiene ventas registradas.');
        }

        $registro = [
            'producto_id' => $producto->id,
            'nombre' => $producto->nombre,
            'usuario_id' => $request->user()->id,
            'ip' => $request->ip(),
        ];

        $producto->delete();

        Log::channel('productos')->info('Producto eliminado', $registro);

        return to_route('productos.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
