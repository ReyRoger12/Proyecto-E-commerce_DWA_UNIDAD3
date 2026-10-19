<x-public-layout title="Inicio">
    <div class="container">
        <section class="hero">
            <div>
                <span class="eyebrow">Bienvenido</span>
                <h1>Compra de forma sencilla y segura.</h1>
                <p>Consulta nuestra información, crea tu cuenta y entra a un espacio pensado para ti. Cada usuario recibe un panel según su nivel de acceso.</p>
                <div class="actions" style="margin-top:24px">
                    @auth
                        <a class="btn btn-primary" href="{{ route('dashboard') }}">Ir a mi panel</a>
                    @else
                        <a class="btn btn-primary" href="{{ route('register') }}">Crear mi cuenta</a>
                        <a class="btn" href="{{ route('login') }}">Ya tengo cuenta</a>
                    @endauth
                </div>
            </div>
            <aside class="hero-card">
                <strong>3</strong>
                <p>perfiles de acceso: Cliente, Empleado y Gerente.</p>
                <p>El sistema muestra a cada usuario únicamente las herramientas correspondientes a su rol.</p>
            </aside>
        </section>

        <section class="section" id="servicios">
            <span class="eyebrow">Lo que encontrarás</span>
            <h2>Una experiencia organizada</h2>
            <p class="section-intro">La plataforma separa las funciones para que cada persona pueda concentrarse en las tareas que le corresponden.</p>
            <div class="grid">
                <article class="card"><div class="icon">C</div><h3>Área del cliente</h3><p>Acceso a su perfil y a las opciones relacionadas con su cuenta y compras.</p></article>
                <article class="card"><div class="icon">E</div><h3>Área del empleado</h3><p>Herramientas operativas para apoyar las actividades diarias del negocio.</p></article>
                <article class="card"><div class="icon">G</div><h3>Área del gerente</h3><p>Vista general para consultar indicadores y administrar la operación.</p></article>
            </div>
        </section>
    </div>
</x-public-layout>
