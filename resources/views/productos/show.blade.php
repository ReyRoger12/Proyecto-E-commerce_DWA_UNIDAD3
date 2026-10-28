<x-catalogo-layout title="{{ $producto->nombre }}" description="Detalle completo del producto.">
    <x-slot:actions><div class="actions"><a class="button button-light" href="{{ route('productos.index') }}">Volver</a>@can('update', $producto)<a class="button button-primary" href="{{ route('productos.edit', $producto) }}">Editar</a>@endcan</div></x-slot:actions>
    <section class="panel"><div class="panel-body"><div class="detail-grid">
        <div class="detail"><span>Vendedor</span><strong>{{ $producto->vendedor->nombre }} {{ $producto->vendedor->apellidos }}</strong></div>
        <div class="detail"><span>Precio</span><strong>${{ number_format((float) $producto->precio, 2) }}</strong></div>
        <div class="detail"><span>Existencia</span><strong>{{ $producto->existencia }} unidades</strong></div>
        <div class="detail"><span>Categorías</span>@foreach($producto->categorias as $categoria)<span class="tag">{{ $categoria->nombre }}</span>@endforeach</div>
        <div class="detail field-wide"><span>Descripción</span>{{ $producto->descripcion }}</div>
    </div></div></section>
</x-catalogo-layout>
