<x-dashboard-layout title="Detalle de venta" description="Información completa de la operación registrada.">
    @include('ventas._styles')

    @if (session('success'))
        <div class="ventas-alert">{{ session('success') }}</div>
    @endif

    <section class="card">
        <dl class="ventas-detail">
            <div><dt>Producto</dt><dd>{{ $venta->producto->nombre }}</dd></div>
            <div><dt>Fecha</dt><dd>{{ $venta->fecha->format('d/m/Y') }}</dd></div>
            <div><dt>Cliente</dt><dd>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellidos }}</dd></div>
            <div><dt>Vendedor</dt><dd>{{ $venta->vendedor->nombre }} {{ $venta->vendedor->apellidos }}</dd></div>
            <div><dt>Total</dt><dd>${{ number_format((float) $venta->total, 2) }}</dd></div>
            <div><dt>Folio</dt><dd>#{{ $venta->id }}</dd></div>
        </dl>

        <div class="ventas-actions" style="margin-top:20px">
            <a class="ventas-button ventas-button-light" href="{{ route('ventas.index') }}">Volver</a>
            @can('update', $venta)
                <a class="ventas-button ventas-button-primary" href="{{ route('ventas.edit', $venta) }}">Editar</a>
            @endcan
        </div>
    </section>
</x-dashboard-layout>
