<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/helpdeskflow.png') }}" alt="Logo" height="32"> HelpDeskFlow
        </a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link">Admin Panel</a></li>
            <li class="nav-item"><a href="{{ route('reportes.index') }}" class="nav-link">Reportes</a></li>
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">@csrf
                    <button class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
                </form>
            </li>
        </ul>
    </div>
</nav>
