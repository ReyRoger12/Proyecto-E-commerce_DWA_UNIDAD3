<x-catalogo-layout title="Registrar producto" description="Completa los datos y asigna al menos una categoría.">
    <section class="panel"><div class="panel-body">
        <form method="POST" action="{{ route('productos.store') }}">@csrf
            @include('productos.form', ['buttonText' => 'Guardar producto'])
        </form>
    </div></section>
</x-catalogo-layout>
