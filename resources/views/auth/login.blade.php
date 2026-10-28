<x-auth-layout title="Iniciar sesión">
    <h1>Iniciar sesión</h1>
    <p>Ingresa con tu correo y contraseña.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="correo">Correo electrónico</label>
        <input id="correo" name="correo" type="email" value="{{ old('correo') }}" required autofocus autocomplete="email">
        @error('correo')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="clave">Contraseña</label>
        <input id="clave" name="clave" type="password" required autocomplete="current-password">
        @error('clave')
            <p class="error">{{ $message }}</p>
        @enderror

        <label class="check" for="recordar">
            <input id="recordar" name="recordar" type="checkbox" value="1">
            Mantener mi sesión abierta
        </label>

        <button type="submit">Entrar</button>
    </form>

    <p class="switch">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
</x-auth-layout>
