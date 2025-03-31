<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #e5e5e5;
        }

        .full-height-center {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background-color: #ffffff;
            width: 100%;
            max-width: 480px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-container img {
            width: 240px;
            margin-bottom: 25px;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-register {
            background-color: #baf266;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            width: 100%;
            color: black;
            font-weight: 500;
        }

        .login-link {
            margin-top: 20px;
            font-size: 0.95rem;
        }

        .login-link a {
            color: #198754;
            font-weight: 500;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .form-row {
            display: flex;
            gap: 10px;
        }

        .form-row .form-control {
            flex: 1;
        }
    </style>
</head>

<body>
    <div class="full-height-center">
        <div class="register-container">

            <img src="{{ asset('images/helpdeskflow.png') }}" alt="Registro">

            @if ($errors->any())
                <div class="alert alert-danger text-start">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3 text-start form-row">
                    <div>
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div>
                        <label for="apellido" class="form-label">Apellido:</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" required>
                    </div>
                </div>

                <div class="mb-3 text-start">
                    <label for="email" class="form-label">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3 text-start">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <div class="mb-3 text-start">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña:</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn-register">Registrarse</button>

                <div class="login-link mt-3">
                    ¿Ya tienes una cuenta?
                    <a href="{{ route('login') }}">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
