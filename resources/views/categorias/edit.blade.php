<x-catalogo-layout title="Editar categoría" description="Actualiza los datos de {{ $categoria->nombre }}.">
    <section class="panel"><div class="panel-body"><form method="POST" action="{{ route('categorias.update', $categoria) }}">@csrf @method('PUT') @include('categorias.form', ['buttonText' => 'Guardar cambios'])</form></div></section>
</x-catalogo-layout>
