<x-auth-layout title="Iniciar sesión">
    <h1>Iniciar sesión</h1>
    <p>Ingresa con tu correo y contraseña.</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label for="email">Correo electrónico</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email">
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="password">Contraseña</label>
        <input id="password" name="password" type="password" required autocomplete="current-password">
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <label class="check" for="remember">
            <input id="remember" name="remember" type="checkbox" value="1">
            Mantener mi sesión abierta
        </label>

        <button type="submit">Entrar</button>
    </form>

    <p class="switch">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
</x-auth-layout>
