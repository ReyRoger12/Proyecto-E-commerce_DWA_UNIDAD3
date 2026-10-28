<x-catalogo-layout title="Editar usuario" description="Actualiza los datos de {{ $usuario->nombre }} {{ $usuario->apellidos }}.">
    <section class="panel">
        <div class="panel-body">
            <form method="POST" action="{{ route('usuarios.update', $usuario) }}">
                @csrf
                @method('PUT')
                @include('usuarios.form', ['buttonText' => 'Guardar cambios'])
            </form>
        </div>
    </section>
</x-catalogo-layout>
