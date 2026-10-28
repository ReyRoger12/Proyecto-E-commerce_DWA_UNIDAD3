@props(['title', 'description' => ''])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | MiTienda</title>
    <style>
        :root{--primary:#2563eb;--primary-dark:#1d4ed8;--ink:#172033;--muted:#667085;--bg:#f6f8fc;--card:#fff;--border:#e5e7eb;--danger:#b42318;--success:#067647}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}a{text-decoration:none;color:inherit}button,input,textarea,select{font:inherit}
        header{background:#fff;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:20}.nav{width:min(1180px,calc(100% - 32px));min-height:70px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:20px}.brand{font-size:1.2rem;font-weight:850}.brand span{color:var(--primary)}.menu{display:flex;align-items:center;gap:8px}.menu a{padding:9px 11px;border-radius:9px;color:var(--muted);font-weight:700;font-size:.9rem}.menu a:hover{color:var(--primary);background:#eff6ff}.user{color:var(--muted);font-size:.85rem}
        main{width:min(1180px,calc(100% - 32px));margin:34px auto 60px}.heading{display:flex;justify-content:space-between;align-items:end;gap:20px;margin-bottom:24px}.heading h1{margin:0 0 7px;font-size:2rem}.heading p{margin:0;color:var(--muted)}.panel{background:var(--card);border:1px solid var(--border);border-radius:16px;box-shadow:0 8px 24px rgba(16,24,40,.04);overflow:hidden}.panel-body{padding:24px}.actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap}
        .button{display:inline-flex;align-items:center;justify-content:center;border:1px solid transparent;border-radius:9px;padding:9px 13px;font-weight:750;cursor:pointer}.button-primary{background:var(--primary);color:#fff}.button-primary:hover{background:var(--primary-dark)}.button-light{border-color:var(--border);background:#fff}.button-danger{border-color:#fecdca;background:#fff5f4;color:var(--danger)}
        .alert{padding:13px 16px;border-radius:10px;margin-bottom:18px}.alert-success{color:var(--success);background:#ecfdf3;border:1px solid #abefc6}.alert-error{color:var(--danger);background:#fff5f4;border:1px solid #fecdca}.alert ul{margin:6px 0 0;padding-left:18px}
        table{width:100%;border-collapse:collapse}th,td{padding:14px 16px;border-bottom:1px solid var(--border);text-align:left;vertical-align:middle}th{color:var(--muted);background:#f9fafb;font-size:.75rem;text-transform:uppercase;letter-spacing:.06em}tr:last-child td{border:0}.muted{color:var(--muted)}.tag{display:inline-block;padding:4px 8px;border-radius:999px;background:#eff6ff;color:#1d4ed8;font-size:.78rem;font-weight:750;margin:2px}.empty{text-align:center;padding:42px;color:var(--muted)}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}.field-wide{grid-column:1/-1}.field label{display:block;margin-bottom:7px;font-weight:750}.field input,.field textarea,.field select{width:100%;border:1px solid #d0d5dd;border-radius:9px;padding:10px 12px;background:#fff}.field textarea{min-height:120px;resize:vertical}.field input:focus,.field textarea:focus,.field select:focus{outline:3px solid #dbeafe;border-color:var(--primary)}.field-error{display:block;margin-top:5px;color:var(--danger)}.checks{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}.check{display:flex;align-items:center;gap:8px;padding:10px;border:1px solid var(--border);border-radius:9px}.check input{width:auto}.form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border)}
        .detail-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px}.detail{padding:15px;border:1px solid var(--border);border-radius:10px}.detail span{display:block;color:var(--muted);font-size:.8rem;margin-bottom:5px}.pagination{margin-top:20px}.logout{border:0;background:transparent;color:var(--muted);font-weight:700;cursor:pointer}
        @media(max-width:760px){.nav{align-items:flex-start;padding:14px 0;flex-direction:column}.menu{width:100%;overflow:auto}.user{display:none}.heading{align-items:flex-start;flex-direction:column}.form-grid,.detail-grid,.checks{grid-template-columns:1fr}.field-wide{grid-column:auto}.panel{overflow-x:auto}}
    </style>
</head>
<body>
@php
    $usuario = auth()->user();
    $nombreUsuario = $usuario->nombre ?? $usuario->name ?? '';
@endphp
<header>
    <div class="nav">
        <a class="brand" href="{{ route('dashboard') }}">Mi<span>Tienda</span></a>
        <nav class="menu" aria-label="Navegación principal">
            <a href="{{ route('dashboard') }}">Panel</a>
            <a href="{{ route('productos.index') }}">Productos</a>
            <a href="{{ route('categorias.index') }}">Categorías</a>
            <a href="{{ route('ventas.index') }}">Ventas</a>
            @can('viewAny', App\Models\Usuario::class)
                <a href="{{ route('usuarios.index') }}">Usuarios</a>
            @endcan
        </nav>
        <div class="actions">
            <span class="user">{{ $nombreUsuario }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">Cerrar sesión</button>
            </form>
        </div>
    </div>
</header>
<main>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-error"><strong>Revisa la información.</strong><ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <div class="heading">
        <div><h1>{{ $title }}</h1>@if($description)<p>{{ $description }}</p>@endif</div>
        {{ $actions ?? '' }}
    </div>
    {{ $slot }}
</main>
</body>
</html>
