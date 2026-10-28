<x-catalogo-layout title="Registrar usuario" description="Crea una cuenta y asigna sus permisos.">
    <section class="panel">
        <div class="panel-body">
            <form method="POST" action="{{ route('usuarios.store') }}">
                @csrf
                @include('usuarios.form', ['buttonText' => 'Guardar usuario'])
            </form>
        </div>
    </section>
</x-catalogo-layout>
