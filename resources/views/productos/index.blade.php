<x-catalogo-layout title="Productos" description="Catálogo con vendedor, existencia y categorías relacionadas.">
    <x-slot:actions>
        @can('create', App\Models\Producto::class)
            <a class="button button-primary" href="{{ route('productos.create') }}">Agregar producto</a>
        @endcan
    </x-slot:actions>
    <section class="panel">
        <table>
            <thead><tr><th>Producto</th><th>Vendedor</th><th>Categorías</th><th>Precio</th><th>Existencia</th><th>Acciones</th></tr></thead>
            <tbody>
            @forelse($productos as $producto)
                <tr>
                    <td><strong>{{ $producto->nombre }}</strong><div class="muted">#{{ $producto->id }}</div></td>
                    <td>{{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}</td>
                    <td>@foreach($producto->categorias as $categoria)<span class="tag">{{ $categoria->nombre }}</span>@endforeach</td>
                    <td>${{ number_format((float) $producto->precio, 2) }}</td>
                    <td>{{ $producto->existencia }}</td>
                    <td><div class="actions">
                        <a class="button button-light" href="{{ route('productos.show', $producto) }}">Ver</a>
                        @can('update', $producto)<a class="button button-light" href="{{ route('productos.edit', $producto) }}">Editar</a>@endcan
                        @can('delete', $producto)
                            <form method="POST" action="{{ route('productos.destroy', $producto) }}" onsubmit="return confirm('¿Eliminar este producto?')">@csrf @method('DELETE')<button class="button button-danger" type="submit">Eliminar</button></form>
                        @endcan
                    </div></td>
                </tr>
            @empty
                <tr><td class="empty" colspan="6">No hay productos registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>
    <div class="pagination">{{ $productos->links() }}</div>
</x-catalogo-layout>
