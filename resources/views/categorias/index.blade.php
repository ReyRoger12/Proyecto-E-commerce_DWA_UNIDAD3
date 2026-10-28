<x-catalogo-layout title="Categorías" description="Organiza los productos del catálogo.">
    <x-slot:actions>
        @can('create', App\Models\Categoria::class)
            <a class="button button-primary" href="{{ route('categorias.create') }}">Agregar categoría</a>
        @endcan
    </x-slot:actions>
    <section class="panel">
        <table>
            <thead><tr><th>Categoría</th><th>Descripción</th><th>Productos</th><th>Acciones</th></tr></thead>
            <tbody>
            @forelse($categorias as $categoria)
                <tr>
                    <td><strong>{{ $categoria->nombre }}</strong></td>
                    <td>{{ Str::limit($categoria->descripcion, 90) }}</td>
                    <td>{{ $categoria->productos_count }}</td>
                    <td><div class="actions">
                        <a class="button button-light" href="{{ route('categorias.show', $categoria) }}">Ver</a>
                        @can('update', $categoria)<a class="button button-light" href="{{ route('categorias.edit', $categoria) }}">Editar</a>@endcan
                        @can('delete', $categoria)<form method="POST" action="{{ route('categorias.destroy', $categoria) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">@csrf @method('DELETE')<button class="button button-danger" type="submit">Eliminar</button></form>@endcan
                    </div></td>
                </tr>
            @empty
                <tr><td class="empty" colspan="4">No hay categorías registradas.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
    <div class="pagination">{{ $categorias->links() }}</div>
</x-catalogo-layout>
