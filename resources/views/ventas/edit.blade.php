<x-dashboard-layout title="Editar venta" description="Actualiza los datos de la operación seleccionada.">
    @include('ventas._styles')

    <section class="card">
        <form action="{{ route('ventas.update', $venta) }}" method="post">
            @csrf
            @method('PUT')
            @include('ventas._form', ['buttonText' => 'Guardar cambios'])
        </form>
    </section>
</x-dashboard-layout>
