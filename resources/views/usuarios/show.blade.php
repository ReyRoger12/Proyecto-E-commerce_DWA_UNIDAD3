<x-catalogo-layout title="{{ $usuario->nombre }} {{ $usuario->apellidos }}" description="Información de la cuenta seleccionada.">
    <x-slot:actions>
        <div class="actions">
            <a class="button button-light" href="{{ route('usuarios.index') }}">Volver</a>
            @can('update', $usuario)
                <a class="button button-primary" href="{{ route('usuarios.edit', $usuario) }}">Editar</a>
            @endcan
        </div>
    </x-slot:actions>

    <section class="panel">
        <div class="panel-body detail-grid">
            <div class="detail"><span>Nombre</span><strong>{{ $usuario->nombre }} {{ $usuario->apellidos }}</strong></div>
            <div class="detail"><span>Correo</span><strong>{{ $usuario->correo }}</strong></div>
            <div class="detail"><span>Rol</span><strong>{{ ucfirst($usuario->rol->value) }}</strong></div>
            <div class="detail"><span>Registro</span><strong>{{ $usuario->created_at->format('d/m/Y H:i') }}</strong></div>
        </div>
    </section>
</x-catalogo-layout>
