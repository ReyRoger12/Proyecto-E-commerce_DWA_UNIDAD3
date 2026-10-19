@props(['title','description' => ''])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | MiTienda</title>
    <style>
        :root{--primary:#2563eb;--primary-dark:#1d4ed8;--ink:#172033;--muted:#667085;--bg:#f6f8fc;--card:#fff;--border:#e5e7eb;--success:#15803d}
        *{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--ink);font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif}a{text-decoration:none;color:inherit}
        header{background:#fff;border-bottom:1px solid var(--border);position:sticky;top:0;z-index:20}.nav{width:min(1180px,calc(100% - 32px));margin:auto;min-height:70px;display:flex;align-items:center;justify-content:space-between;gap:18px}.brand{font-size:1.2rem;font-weight:800}.brand span{color:var(--primary)}.user-area{display:flex;align-items:center;gap:14px}.user-info{text-align:right}.user-info strong{display:block}.user-info small{color:var(--muted)}
        .logout{border:1px solid var(--border);background:#fff;padding:9px 13px;border-radius:9px;font-weight:700;cursor:pointer}.logout:hover{border-color:#cbd5e1;background:#f8fafc}
        main{width:min(1180px,calc(100% - 32px));margin:34px auto 60px}.heading{margin-bottom:24px}.heading h1{margin:0 0 8px;font-size:2rem}.heading p{margin:0;color:var(--muted)}.content-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}.card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:22px;box-shadow:0 8px 24px rgba(16,24,40,.04)}.card .number{font-size:.78rem;font-weight:800;color:var(--primary);text-transform:uppercase;letter-spacing:.08em}.card h2{margin:8px 0}.card p{color:var(--muted);line-height:1.55}.action{display:inline-block;margin-top:12px;background:var(--primary);color:#fff;padding:9px 13px;border-radius:9px;font-weight:700}.action:hover{background:var(--primary-dark)}.notice{padding:14px 16px;border-radius:10px;background:#eff6ff;border:1px solid #dbeafe;color:#1e40af;margin-bottom:20px}.list{margin:14px 0 0;padding-left:18px;color:#475467}.list li{margin:8px 0}.stat{font-size:2rem;font-weight:800;margin:8px 0}.status{display:inline-block;padding:5px 9px;border-radius:999px;background:#ecfdf3;color:var(--success);font-size:.8rem;font-weight:800}
        @media(max-width:850px){.content-grid{grid-template-columns:1fr}.user-info{display:none}}
    </style>
</head>
<body>
<header>
    <div class="nav">
        <a class="brand" href="{{ route('home') }}">Mi<span>Tienda</span></a>
        <div class="user-area">
            <div class="user-info"><strong>{{ auth()->user()->name }}</strong><small>{{ ucfirst(auth()->user()->role->value) }}</small></div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="logout" type="submit">Cerrar sesiÃ³n</button>
            </form>
        </div>
    </div>
</header>
<main>
    <div class="heading">
        <h1>{{ $title }}</h1>
        @if($description)<p>{{ $description }}</p>@endif
    </div>
    {{ $slot }}
</main>
</body>
</html>
