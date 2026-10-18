<x-auth-layout title="Crear cuenta">
    <h1>Crear cuenta</h1>
    <p>Regístrate para empezar a comprar.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label for="name">Nombre</label>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name">
        @error('name')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="email">Correo electrónico</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email">
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="password">Contraseña</label>
        <input id="password" name="password" type="password" required autocomplete="new-password">
        @error('password')
            <p class="error">{{ $message }}</p>
        @enderror

        <label for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password">

        <button type="submit">Registrarme</button>
    </form>

    <p class="switch">¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
</x-auth-layout>
