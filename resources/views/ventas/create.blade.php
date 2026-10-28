<x-dashboard-layout title="Registrar venta" description="Relaciona el producto con su cliente y vendedor.">
    @include('ventas._styles')

    <section class="card">
        <form action="{{ route('ventas.store') }}" method="post">
            @csrf
            @include('ventas._form', ['buttonText' => 'Guardar venta'])
        </form>
    </section>
</x-dashboard-layout>
