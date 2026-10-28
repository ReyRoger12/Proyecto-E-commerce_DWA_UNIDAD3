<x-catalogo-layout title="Registrar categoría" description="Crea una categoría para organizar los productos.">
    <section class="panel"><div class="panel-body"><form method="POST" action="{{ route('categorias.store') }}">@csrf @include('categorias.form', ['buttonText' => 'Guardar categoría'])</form></div></section>
</x-catalogo-layout>
