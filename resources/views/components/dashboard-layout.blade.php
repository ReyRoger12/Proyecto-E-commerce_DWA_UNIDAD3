@props(['title'])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} | Tienda</title>
    <style>
        :root { color-scheme: light; font-family: Inter, ui-sans-serif, system-ui, sans-serif; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f5f5f4; color: #1c1917; }
        header { display: flex; justify-content: space-between; align-items: center; gap: 1rem; padding: 1rem max(1.25rem, calc((100vw - 70rem) / 2)); background: #fff; border-bottom: 1px solid #e7e5e4; }
        header p { margin: 0; }
        main { width: min(100% - 2.5rem, 70rem); margin: 3rem auto; padding: 2rem; border: 1px solid #e7e5e4; border-radius: 1rem; background: #fff; }
        h1 { margin-top: 0; }
        button { padding: .65rem 1rem; border: 0; border-radius: .5rem; background: #1c1917; color: #fff; font: inherit; cursor: pointer; }
    </style>
</head>
<body>
    <header>
        <p>{{ auth()->user()->name }}</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </header>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
