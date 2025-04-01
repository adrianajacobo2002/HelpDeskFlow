<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        {{-- Logo y título --}}
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <img src="{{ asset('images/helpdeskflow.png') }}" alt="Logo" height="32" class="me-2">
        </a>

        {{-- Botón de colapso en móvil --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menú de navegación --}}
        <div class="collapse navbar-collapse justify-content-end" id="navbarAdmin">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('admin.tickets.index') }}" class="nav-link">Tickets</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Categorías</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Reportes</a> {{-- Ruta desactivada por ahora --}}
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarProfile"
                        role="button" data-bs-toggle="dropdown">
                        <img src="{{ asset('images/avatar.png') }}" alt="Avatar" class="rounded-circle me-2"
                            height="32">
                        <span>Admin</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button class="dropdown-item text-danger">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
