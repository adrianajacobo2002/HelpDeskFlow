<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        {{-- Logo y título --}}
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/helpdeskflow.png') }}" alt="Logo" height="32">
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
                    <a href="{{ route('admin.usuarios.index') }}" class="nav-link">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categorias.index') }}" class="nav-link">Categorías</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reportes.index') }}" class="nav-link">Reportes</a>
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
