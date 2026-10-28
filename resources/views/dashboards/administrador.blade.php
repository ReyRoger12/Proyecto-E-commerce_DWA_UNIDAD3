<x-dashboard-layout title="Panel de administrador" description="Control general de usuarios, catálogo y ventas del sistema.">
    <div class="notice">Bienvenido, {{ auth()->user()->nombre }}. Tienes acceso administrativo al E-commerce.</div>
    <section class="content-grid">
        <article class="card"><span class="number">01 · Catálogo</span><h2>Productos</h2><p>Administra productos, vendedores, existencias y categorías.</p><a class="action" href="{{ route('productos.index') }}">Ver productos</a></article>
        <article class="card"><span class="number">02 · Clasificación</span><h2>Categorías</h2><p>Consulta y organiza las categorías disponibles.</p><a class="action" href="{{ route('categorias.index') }}">Ver categorías</a></article>
        <article class="card"><span class="number">03 · Operación</span><h2>Ventas</h2><p>Supervisa las ventas y sus participantes.</p><a class="action" href="{{ route('ventas.index') }}">Ver ventas</a></article>
        <article class="card"><span class="number">04 · Accesos</span><h2>Usuarios</h2><p>Administra cuentas, datos personales y roles.</p><a class="action" href="{{ route('usuarios.index') }}">Ver usuarios</a></article>
    </section>
</x-dashboard-layout>
