<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #e5e5e5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .login-container {
            background-color: #ffffff;
            width: 600px;
            padding: 60px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-container img {
            width: 300px;
            margin-bottom: 30px;
        }

        .form-control {
            border-radius: 20px;
        }

        .btn-login {
            background-color: #baf266;
            border: none;
            border-radius: 20px;
            padding: 10px 20px;
            width: 100%;
            color: black;
        }

        .register-link {
            margin-top: 20px;
            font-size: 0.95rem;
        }
    </style>
</head>

<body>
    <div class="login-container">

        <img src="{{ asset('images/helpdeskflow.png') }}" alt="Login Icon">

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label">Correo Electrónico:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3 text-start">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login mt-3">Iniciar Sesión</button>

            <div class="register-link text-center">
                ¿No tienes una cuenta? <a href="{{ route('register.form') }}">Regístrate aquí</a>
            </div>
        </form>
    </div>
</body>

</html>
