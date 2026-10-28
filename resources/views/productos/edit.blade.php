<x-catalogo-layout title="Editar producto" description="Actualiza la información de {{ $producto->nombre }}.">
    <section class="panel"><div class="panel-body">
        <form method="POST" action="{{ route('productos.update', $producto) }}">@csrf @method('PUT')
            @include('productos.form', ['buttonText' => 'Guardar cambios'])
        </form>
    </div></section>
</x-catalogo-layout>
