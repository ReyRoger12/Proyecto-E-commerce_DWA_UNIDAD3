@props(['title' => 'Tienda'])
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Tienda</title>
    <style>
        :root{--primary:#2563eb;--primary-dark:#1d4ed8;--ink:#172033;--muted:#667085;--bg:#f6f8fc;--card:#fff;--border:#e5e7eb}
        *{box-sizing:border-box}html{scroll-behavior:smooth}body{margin:0;font-family:Inter,ui-sans-serif,system-ui,-apple-system,"Segoe UI",sans-serif;background:var(--bg);color:var(--ink)}
        a{text-decoration:none;color:inherit}.container{width:min(1120px,calc(100% - 40px));margin:auto}
        header{position:sticky;top:0;z-index:20;background:rgba(255,255,255,.94);backdrop-filter:blur(10px);border-bottom:1px solid var(--border)}
        .nav{min-height:72px;display:flex;align-items:center;justify-content:space-between;gap:20px}.brand{font-weight:800;font-size:1.25rem}.brand span{color:var(--primary)}
        .nav-links{display:flex;align-items:center;gap:20px;color:#475467;font-size:.95rem}.nav-links a:hover{color:var(--primary)}
        .actions{display:flex;gap:10px;align-items:center}.btn{display:inline-flex;align-items:center;justify-content:center;padding:11px 16px;border-radius:10px;font-weight:700;border:1px solid var(--border);background:#fff}.btn-primary{background:var(--primary);border-color:var(--primary);color:#fff}.btn-primary:hover{background:var(--primary-dark)}
        main{padding:48px 0 70px}.hero{display:grid;grid-template-columns:1.2fr .8fr;gap:32px;align-items:center;padding:55px 0}.eyebrow{display:inline-block;color:var(--primary);font-weight:800;text-transform:uppercase;letter-spacing:.08em;font-size:.78rem;margin-bottom:12px}.hero h1{font-size:clamp(2.2rem,5vw,4rem);line-height:1.04;margin:0 0 18px}.hero p{font-size:1.08rem;color:var(--muted);line-height:1.7;max-width:650px}.hero-card{background:linear-gradient(145deg,#eaf1ff,#fff);border:1px solid #dbe5ff;border-radius:24px;padding:32px;box-shadow:0 18px 50px rgba(31,65,114,.10)}
        .hero-card strong{font-size:3rem;display:block;color:var(--primary)}.section{padding:35px 0}.section h2{font-size:2rem;margin:0 0 10px}.section-intro{color:var(--muted);max-width:700px;line-height:1.6}.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:24px}.card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:24px;box-shadow:0 8px 24px rgba(16,24,40,.04)}.card h3{margin:0 0 8px}.card p{color:var(--muted);line-height:1.6;margin:0}.icon{width:42px;height:42px;display:grid;place-items:center;border-radius:12px;background:#eaf1ff;color:var(--primary);font-weight:800;margin-bottom:15px}
        footer{border-top:1px solid var(--border);background:#fff;padding:28px 0;color:var(--muted);font-size:.92rem}.footer-inner{display:flex;justify-content:space-between;gap:20px;flex-wrap:wrap}
        @media(max-width:800px){.nav-links{display:none}.hero{grid-template-columns:1fr;padding:30px 0}.grid{grid-template-columns:1fr}.container{width:min(100% - 28px,1120px)}}
    </style>
</head>
<body>
<header>
    <div class="container nav">
        <a class="brand" href="{{ route('home') }}">Mi<span>Tienda</span></a>
        <nav class="nav-links" aria-label="Navegación principal">
            <a href="{{ route('home') }}">Inicio</a>
            <a href="{{ route('nosotros') }}">Quiénes somos</a>
            <a href="{{ route('contacto') }}">Contáctanos</a>
        </nav>
        <div class="actions">
            @auth
                <a class="btn btn-primary" href="{{ route('dashboard') }}">Mi panel</a>
            @else
                <a class="btn" href="{{ route('login') }}">Iniciar sesión</a>
                <a class="btn btn-primary" href="{{ route('register') }}">Registrarse</a>
            @endauth
        </div>
    </div>
</header>
<main>
    {{ $slot }}
</main>
<footer>
    <div class="container footer-inner">
        <span>© {{ date('Y') }} MiTienda. Todos los derechos reservados.</span>
        <span>Atención y servicio para nuestros clientes.</span>
    </div>
</footer>
</body>
</html>
