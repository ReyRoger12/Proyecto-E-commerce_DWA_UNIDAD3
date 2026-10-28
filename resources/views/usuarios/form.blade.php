<div class="form-grid">
    <div class="field">
        <label for="nombre">Nombre</label>
        <input id="nombre" name="nombre" value="{{ old('nombre', $usuario->nombre ?? '') }}" maxlength="100" required>
        @error('nombre')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="field">
        <label for="apellidos">Apellidos</label>
        <input id="apellidos" name="apellidos" value="{{ old('apellidos', $usuario->apellidos ?? '') }}" maxlength="150" required>
        @error('apellidos')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="field field-wide">
        <label for="correo">Correo</label>
        <input id="correo" name="correo" type="email" value="{{ old('correo', $usuario->correo ?? '') }}" maxlength="255" required>
        @error('correo')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="field">
        <label for="clave">Contraseña {{ isset($usuario) ? '(opcional)' : '' }}</label>
        <input id="clave" name="clave" type="password" minlength="3" {{ isset($usuario) ? '' : 'required' }}>
        @error('clave')<small class="field-error">{{ $message }}</small>@enderror
    </div>
    <div class="field">
        <label for="clave_confirmation">Confirmar contraseña</label>
        <input id="clave_confirmation" name="clave_confirmation" type="password" minlength="3" {{ isset($usuario) ? '' : 'required' }}>
    </div>
    <div class="field field-wide">
        <label for="rol">Rol</label>
        <select id="rol" name="rol" required>
            @foreach($roles as $rol)
                <option value="{{ $rol->value }}" @selected(old('rol', $usuario->rol->value ?? '') === $rol->value)>{{ ucfirst($rol->value) }}</option>
            @endforeach
        </select>
        @error('rol')<small class="field-error">{{ $message }}</small>@enderror
    </div>
</div>

<div class="form-actions">
    <a class="button button-light" href="{{ route('usuarios.index') }}">Cancelar</a>
    <button class="button button-primary" type="submit">{{ $buttonText }}</button>
</div>
