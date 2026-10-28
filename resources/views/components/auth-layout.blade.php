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
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; background: #f5f5f4; color: #1c1917; }
        main { width: min(92vw, 28rem); padding: 2rem; border: 1px solid #e7e5e4; border-radius: 1rem; background: #fff; box-shadow: 0 1rem 3rem rgb(28 25 23 / 8%); }
        h1 { margin: 0 0 .5rem; font-size: 1.8rem; }
        p { color: #57534e; }
        label { display: block; margin-top: 1rem; font-weight: 650; }
        input[type="text"], input[type="email"], input[type="password"] { width: 100%; margin-top: .4rem; padding: .75rem; border: 1px solid #d6d3d1; border-radius: .55rem; font: inherit; }
        input:focus { border-color: #0f766e; outline: 3px solid #ccfbf1; }
        .check { display: flex; gap: .5rem; align-items: center; font-weight: 400; }
        .error { margin: .35rem 0 0; color: #b91c1c; font-size: .9rem; }
        button { width: 100%; margin-top: 1.4rem; padding: .8rem; border: 0; border-radius: .55rem; background: #0f766e; color: #fff; font: inherit; font-weight: 700; cursor: pointer; }
        a { color: #0f766e; }
        .switch { margin: 1.25rem 0 0; text-align: center; }
    </style>
</head>
<body>
    <main>
        {{ $slot }}
    </main>
</body>
</html>
