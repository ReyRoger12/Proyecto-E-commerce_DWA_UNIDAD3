<x-dashboard-layout title="Panel de cliente" description="Consulta tu cuenta y encuentra rápidamente las opciones disponibles para ti.">
    <div class="notice">Bienvenido, {{ auth()->user()->nombre }}. Este panel es exclusivo para clientes.</div>
    <section class="content-grid">
        <article class="card"><span class="number">01 · Cuenta</span><h2>Mi perfil</h2><p>Consulta la información básica asociada a tu cuenta.</p><a class="action" href="#perfil">Ver perfil</a></article>
        <article class="card"><span class="number">02 · Compras</span><h2>Mis compras</h2><p>Consulta el historial de tus compras y revisa sus datos.</p><a class="action" href="#compras">Ver historial</a></article>
        <article class="card"><span class="number">03 · Atención</span><h2>Ayuda</h2><p>Encuentra información de contacto para resolver dudas.</p><a class="action" href="{{ route('contacto') }}">Contactarnos</a></article>
    </section>
    <section id="perfil" class="card" style="margin-top:18px"><span class="number">Resumen</span><h2>Información de mi cuenta</h2><ul class="list"><li><strong>Nombre:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellidos }}</li><li><strong>Correo:</strong> {{ auth()->user()->correo }}</li><li><strong>Rol:</strong> Cliente</li></ul></section>
    <section id="compras" class="card" style="margin-top:18px"><span class="number">Historial</span><h2>Mis compras</h2><p>Consulta las ventas registradas a tu nombre desde el módulo de ventas.</p><a class="action" href="{{ route('ventas.index') }}">Ver compras</a></section>
</x-dashboard-layout>
