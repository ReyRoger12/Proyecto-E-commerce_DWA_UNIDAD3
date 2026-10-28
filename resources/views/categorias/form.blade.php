<div class="form-grid">
    <div class="field field-wide"><label for="nombre">Nombre</label><input id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre ?? '') }}" maxlength="255" required>@error('nombre')<small class="field-error">{{ $message }}</small>@enderror</div>
    <div class="field field-wide"><label for="descripcion">Descripción</label><textarea id="descripcion" name="descripcion" maxlength="1000" required>{{ old('descripcion', $categoria->descripcion ?? '') }}</textarea>@error('descripcion')<small class="field-error">{{ $message }}</small>@enderror</div>
</div>
<div class="form-actions"><a class="button button-light" href="{{ route('categorias.index') }}">Cancelar</a><button class="button button-primary" type="submit">{{ $buttonText }}</button></div>
