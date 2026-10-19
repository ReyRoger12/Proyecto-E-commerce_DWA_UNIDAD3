<x-dashboard-layout title="Panel de empleado" description="Herramientas operativas para las actividades diarias del negocio.">
    <div class="notice">Bienvenido, {{ auth()->user()->name }}. Este panel contiene las funciones correspondientes al rol Empleado.</div>
    <section class="content-grid">
        <article class="card"><span class="number">01 · Operación</span><h2>Gestión diaria</h2><p>Espacio destinado a las tareas operativas y seguimiento de actividades.</p><a class="action" href="#operacion">Consultar</a></article>
        <article class="card"><span class="number">02 · Clientes</span><h2>Atención al cliente</h2><p>Consulta y apoyo a las solicitudes que correspondan al personal operativo.</p><a class="action" href="#clientes">Consultar</a></article>
        <article class="card"><span class="number">03 · Reportes</span><h2>Reportes operativos</h2><p>Acceso a información necesaria para dar seguimiento a la operación.</p><a class="action" href="#reportes">Consultar</a></article>
    </section>
    <section id="operacion" class="card" style="margin-top:18px"><span class="number">Estado</span><h2>Actividades</h2><p><span class="status">Panel disponible</span></p><ul class="list"><li>Revisar actividades pendientes.</li><li>Dar seguimiento a la atención de clientes.</li><li>Preparar información para los reportes.</li></ul></section>
    <section id="clientes" class="card" style="margin-top:18px"><span class="number">Clientes</span><h2>Atención</h2><p>Esta sección queda preparada para conectar posteriormente las operaciones reales del negocio.</p></section>
    <section id="reportes" class="card" style="margin-top:18px"><span class="number">Reportes</span><h2>Información operativa</h2><p>Los reportes reales se agregarán en la siguiente etapa cuando existan los módulos de negocio correspondientes.</p></section>
</x-dashboard-layout>
