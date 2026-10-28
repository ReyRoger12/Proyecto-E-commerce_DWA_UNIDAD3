<x-dashboard-layout title="Ventas" description="Consulta las compras y ventas registradas en el sistema.">
    @include('ventas._styles')

    @if (session('success'))
        <div class="ventas-alert">{{ session('success') }}</div>
    @endif

    <div class="ventas-toolbar">
        <p>Registros encontrados: <strong>{{ $ventas->count() }}</strong></p>
        @can('create', \App\Models\Venta::class)
            <a class="ventas-button ventas-button-primary" href="{{ route('ventas.create') }}">Registrar venta</a>
        @endcan
    </div>

    <section class="card">
        <table class="ventas-table">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->fecha->format('d/m/Y') }}</td>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</td>
                        <td>{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</td>
                        <td>${{ number_format((float) $venta->total, 2) }}</td>
                        <td>
                            <div class="ventas-actions">
                                <a class="ventas-button ventas-button-light" href="{{ route('ventas.show', $venta) }}">Ver</a>
                                @can('update', $venta)
                                    <a class="ventas-button ventas-button-light" href="{{ route('ventas.edit', $venta) }}">Editar</a>
                                @endcan
                                @can('delete', $venta)
                                    <form action="{{ route('ventas.destroy', $venta) }}" method="post" onsubmit="return confirm('¿Eliminar esta venta?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="ventas-button ventas-button-danger" type="submit">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td class="ventas-empty" colspan="6">Todavía no hay ventas registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</x-dashboard-layout>
