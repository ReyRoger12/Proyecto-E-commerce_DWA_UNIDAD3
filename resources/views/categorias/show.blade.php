<x-catalogo-layout title="{{ $categoria->nombre }}" description="Productos relacionados con esta categoría.">
    <x-slot:actions><div class="actions"><a class="button button-light" href="{{ route('categorias.index') }}">Volver</a>@can('update', $categoria)<a class="button button-primary" href="{{ route('categorias.edit', $categoria) }}">Editar</a>@endcan</div></x-slot:actions>
    <section class="panel"><div class="panel-body"><p>{{ $categoria->descripcion }}</p></div>
        <table><thead><tr><th>Producto</th><th>Vendedor</th><th>Precio</th><th>Existencia</th></tr></thead><tbody>
        @forelse($categoria->productos as $producto)
            <tr><td><a href="{{ route('productos.show', $producto) }}"><strong>{{ $producto->nombre }}</strong></a></td><td>{{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}</td><td>${{ number_format((float) $producto->precio, 2) }}</td><td>{{ $producto->existencia }}</td></tr>
        @empty<tr><td class="empty" colspan="4">Esta categoría todavía no tiene productos.</td></tr>@endforelse
        </tbody></table>
    </section>
</x-catalogo-layout>
