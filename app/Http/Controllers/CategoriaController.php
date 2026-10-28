<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        Gate::authorize('viewAny', Categoria::class);

        $categorias = Categoria::query()
            ->withCount('productos')
            ->orderBy('nombre')
            ->paginate(12);

        return view('categorias.index', compact('categorias'));
    }

    public function create(): View
    {
        Gate::authorize('create', Categoria::class);

        return view('categorias.create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        Categoria::create($request->validated());

        return to_route('categorias.index')
            ->with('success', 'Categoría registrada correctamente.');
    }

    public function show(Categoria $categoria): View
    {
        Gate::authorize('view', $categoria);

        $categoria->load(['productos.vendedor']);

        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria): View
    {
        Gate::authorize('update', $categoria);

        return view('categorias.edit', compact('categoria'));
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $categoria->update($request->validated());

        return to_route('categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        Gate::authorize('delete', $categoria);

        $categoria->delete();

        return to_route('categorias.index')
            ->with('success', 'Categoría eliminada correctamente.');
    }
}
