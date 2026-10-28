<x-auth-layout title="Crear cuenta">
    <h1>Crear cuenta</h1>
    <p>Regístrate para empezar a comprar.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}" required autofocus autocomplete="given-name">
        @error('nombre')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="apellidos">Apellidos</label>
        <input id="apellidos" name="apellidos" type="text" value="{{ old('apellidos') }}" required autocomplete="family-name">
        @error('apellidos')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="correo">Correo electrónico</label>
        <input id="correo" name="correo" type="email" value="{{ old('correo') }}" required autocomplete="email">
        @error('correo')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="clave">Contraseña</label>
        <input id="clave" name="clave" type="password" required autocomplete="new-password">
        @error('clave')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="clave_confirmation">Confirmar contraseña</label>
        <input id="clave_confirmation" name="clave_confirmation" type="password" required autocomplete="new-password">

        <button type="submit">Registrarme</button>
    </form>

    <p class="switch">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
</x-auth-layout>
