<?php
include 'db.php';
session_start();

// Verificar que el usuario esté logueado y sea admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    echo "Acceso denegado.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $rol = $_POST['rol'];

    // Verificar si el correo ya está registrado
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "El correo ya está registrado. Por favor, usa otro.";
    } else {
        // Insertar nuevo usuario
        $contraseña_hash = password_hash($contraseña, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo, contraseña, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre_usuario, $correo, $contraseña_hash, $rol);

        if ($stmt->execute()) {
            echo "Usuario registrado exitosamente.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Agregar Usuario</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h2>Registrar Nuevo Usuario</h2>
            <form method="POST" action="admin_add_user.php">
                <input type="text" name="nombre_usuario" placeholder="Nombre de Usuario" required>
                <input type="email" name="correo" placeholder="Correo" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <select name="rol" required>
                    <option value="cliente">Cliente</option>
                    <option value="admin">Administrador</option>
                </select>
                <button type="submit">Registrar</button>
            </form>
        </div>
    </main>
  
    <script src="script.js"></script>
</body>
</html>
