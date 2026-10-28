<div class="ventas-form">
    <div class="ventas-field ventas-field-wide">
        <label for="producto_id">Producto</label>
        <select id="producto_id" name="producto_id" required>
            <option value="">Selecciona un producto</option>
            @foreach ($productos as $producto)
                <option
                    value="{{ $producto->id }}"
                    data-vendedor-id="{{ $producto->usuario_id }}"
                    data-vendedor="{{ $producto->vendedor?->nombre }} {{ $producto->vendedor?->apellidos }}"
                    @selected((string) old('producto_id', $venta->producto_id ?? '') === (string) $producto->id)
                >
                    {{ $producto->nombre }} — ${{ number_format((float) $producto->precio, 2) }}
                </option>
            @endforeach
        </select>
        @error('producto_id')<small>{{ $message }}</small>@enderror
    </div>

    <div class="ventas-field">
        <label for="vendedor_nombre">Vendedor</label>
        <input id="vendedor_nombre" type="text" value="" readonly>
        <input id="vendedor_id" name="vendedor_id" type="hidden" value="{{ old('vendedor_id', $venta->vendedor_id ?? '') }}">
        @error('vendedor_id')<small>{{ $message }}</small>@enderror
    </div>

    <div class="ventas-field">
        <label for="cliente_id">Cliente</label>
        <select id="cliente_id" name="cliente_id" required>
            <option value="">Selecciona un cliente</option>
            @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id }}" @selected((string) old('cliente_id', $venta->cliente_id ?? auth()->id()) === (string) $usuario->id)>
                    {{ $usuario->nombre }} {{ $usuario->apellidos }} — {{ $usuario->rol instanceof \BackedEnum ? $usuario->rol->value : $usuario->rol }}
                </option>
            @endforeach
        </select>
        @error('cliente_id')<small>{{ $message }}</small>@enderror
    </div>

    <div class="ventas-field">
        <label for="fecha">Fecha</label>
        <input id="fecha" name="fecha" type="date" value="{{ old('fecha', isset($venta) ? $venta->fecha->format('Y-m-d') : now()->format('Y-m-d')) }}" required>
        @error('fecha')<small>{{ $message }}</small>@enderror
    </div>

    <div class="ventas-field">
        <label for="total">Total</label>
        <input id="total" name="total" type="number" min="0.01" max="99999999.99" step="0.01" value="{{ old('total', $venta->total ?? '') }}" required>
        @error('total')<small>{{ $message }}</small>@enderror
    </div>

    <div class="ventas-form-actions">
        <a class="ventas-button ventas-button-light" href="{{ route('ventas.index') }}">Cancelar</a>
        <button class="ventas-button ventas-button-primary" type="submit">{{ $buttonText }}</button>
    </div>
</div>

<script>
    (() => {
        const producto = document.getElementById('producto_id');
        const vendedorId = document.getElementById('vendedor_id');
        const vendedorNombre = document.getElementById('vendedor_nombre');

        const actualizarVendedor = () => {
            const opcion = producto.options[producto.selectedIndex];
            vendedorId.value = opcion?.dataset.vendedorId ?? '';
            vendedorNombre.value = opcion?.dataset.vendedor?.trim() || 'Selecciona un producto';
        };

        producto.addEventListener('change', actualizarVendedor);
        actualizarVendedor();
    })();
</script>
