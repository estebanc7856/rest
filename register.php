<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Registrarse</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="login.php">Iniciar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h2>Registro de Usuario</h2>
            <form method="POST" action="register_process.php">
                <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" required>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                
                <!-- Campo para seleccionar el rol -->
                <label for="rol">Rol:</label>
                <select name="rol" id="rol" required>
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                </select>
                
                <button type="submit">Registrar</button>
            </form>
            <p>¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
        </div>
    </main>
   
    <script src="script.js"></script>
</body>
</html>
