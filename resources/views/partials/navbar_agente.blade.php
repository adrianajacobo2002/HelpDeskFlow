<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <!-- Logo y enlace al dashboard -->
        <a class="navbar-brand fw-bold" href="{{ route('agente.dashboard') }}">
            <img src="{{ asset('images/helpdeskflow.png') }}" alt="Logo" height="32">
        </a>

        <!-- Botón de colapso para móviles -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAgente"
            aria-controls="navbarAgente" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú -->
        <div class="collapse navbar-collapse" id="navbarAgente">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a href="{{ route('agente.tickets') }}" class="nav-link">Tickets Asignados</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="dropdown-item p-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
