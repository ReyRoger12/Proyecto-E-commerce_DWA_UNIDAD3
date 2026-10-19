<x-dashboard-layout title="Panel de gerente" description="Vista general para administrar y supervisar la operación del negocio.">
    <div class="notice">Bienvenido, {{ auth()->user()->name }}. Este panel es exclusivo para el rol Gerente.</div>
    <section class="content-grid">
        <article class="card"><span class="number">01 · Resumen</span><h2>Indicadores</h2><p>Vista preparada para mostrar los principales datos del negocio.</p><div class="stat">—</div><small style="color:#667085">Sin datos conectados todavía</small></article>
        <article class="card"><span class="number">02 · Personal</span><h2>Empleados</h2><p>Área destinada a supervisar y consultar la operación del personal.</p><a class="action" href="#personal">Administrar</a></article>
        <article class="card"><span class="number">03 · Control</span><h2>Reportes</h2><p>Acceso a información general para apoyar la toma de decisiones.</p><a class="action" href="#reportes">Ver reportes</a></article>
    </section>
    <section id="personal" class="card" style="margin-top:18px"><span class="number">Administración</span><h2>Control del personal</h2><p>Sección preparada para integrar posteriormente altas, consultas, edición y seguimiento de empleados.</p></section>
    <section id="reportes" class="card" style="margin-top:18px"><span class="number">Supervisión</span><h2>Reportes generales</h2><ul class="list"><li>Resumen de la operación.</li><li>Seguimiento de actividades.</li><li>Indicadores generales del negocio.</li></ul></section>
</x-dashboard-layout>
