<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <img src="{{ asset('images/helpdeskflow.png') }}" alt="Logo" height="32"> HelpDeskFlow
        </a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="{{ route('login') }}" class="nav-link">Iniciar sesión</a></li>
            <li class="nav-item"><a href="{{ route('register.form') }}" class="nav-link">Registrarse</a></li>
        </ul>
    </div>
</nav>
