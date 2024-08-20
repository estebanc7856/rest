<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Iniciar Sesión</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="register.php">Registrarse</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h2>Iniciar Sesión</h2>
            <form method="POST" action="login_process.php">
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <button type="submit">Iniciar Sesión</button>
            </form>
            <p>¿No tienes una cuenta? <a href="register.php">Regístrate aquí</a></p>
        </div>
    </main>
    
    <script src="script.js"></script>
</body>
</html>
