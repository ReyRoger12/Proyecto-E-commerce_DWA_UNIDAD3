<x-catalogo-layout title="Usuarios" description="Administración de cuentas y permisos del sistema.">
    <x-slot:actions>
        @can('create', App\Models\Usuario::class)
            <a class="button button-primary" href="{{ route('usuarios.create') }}">Agregar usuario</a>
        @endcan
    </x-slot:actions>

    <section class="panel">
        <table>
            <thead>
                <tr><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr>
            </thead>
            <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td><strong>{{ $usuario->nombre }} {{ $usuario->apellidos }}</strong><div class="muted">#{{ $usuario->id }}</div></td>
                    <td>{{ $usuario->correo }}</td>
                    <td><span class="tag">{{ ucfirst($usuario->rol->value) }}</span></td>
                    <td>
                        <div class="actions">
                            @can('view', $usuario)
                                <a class="button button-light" href="{{ route('usuarios.show', $usuario) }}">Ver</a>
                            @endcan
                            @can('update', $usuario)
                                <a class="button button-light" href="{{ route('usuarios.edit', $usuario) }}">Editar</a>
                            @endcan
                            @can('delete', $usuario)
                                <form method="POST" action="{{ route('usuarios.destroy', $usuario) }}" onsubmit="return confirm('¿Eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="button button-danger" type="submit">Eliminar</button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td class="empty" colspan="4">No hay usuarios registrados.</td></tr>
            @endforelse
            </tbody>
        </table>
    </section>

    <div class="pagination">{{ $usuarios->links() }}</div>
</x-catalogo-layout>
