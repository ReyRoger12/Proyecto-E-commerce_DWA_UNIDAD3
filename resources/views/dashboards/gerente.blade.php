<x-dashboard-layout title="Panel de gerente" description="Vista general para administrar y supervisar la operación del negocio.">
    <div class="notice">Bienvenido, {{ auth()->user()->nombre }}. Este panel es exclusivo para el rol Gerente.</div>
    <section class="content-grid">
        <article class="card"><span class="number">01 · Catálogo</span><h2>Productos</h2><p>Administra productos, existencias, vendedores y categorías.</p><a class="action" href="{{ route('productos.index') }}">Administrar</a></article>
        <article class="card"><span class="number">02 · Clasificación</span><h2>Categorías</h2><p>Organiza el catálogo y revisa los productos relacionados.</p><a class="action" href="{{ route('categorias.index') }}">Administrar</a></article>
        <article class="card"><span class="number">03 · Operación</span><h2>Ventas</h2><p>Consulta, registra y actualiza las ventas del sistema.</p><a class="action" href="{{ route('ventas.index') }}">Ver ventas</a></article>
        <article class="card"><span class="number">04 · Clientes</span><h2>Usuarios</h2><p>Consulta y actualiza las cuentas con rol Cliente.</p><a class="action" href="{{ route('usuarios.index') }}">Ver clientes</a></article>
    </section>
    <section id="reportes" class="card" style="margin-top:18px"><span class="number">Supervisión</span><h2>Reportes generales</h2><ul class="list"><li>Resumen de la operación.</li><li>Seguimiento de actividades.</li><li>Indicadores generales del negocio.</li></ul></section>
</x-dashboard-layout>
