<?php
include 'db.php';
session_start();

if ($_SESSION['rol'] != 'admin') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $disponible = isset($_POST['disponible']) ? 1 : 0;

    $sql = "INSERT INTO productos (nombre_producto, descripcion, precio, disponible) VALUES ('$nombre_producto', '$descripcion', '$precio', '$disponible')";

    if ($conn->query($sql) === TRUE) {
        echo "Producto agregado exitosamente.";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Agregar Producto</h1>
            <nav>
                <ul>
                    <li><a href="dashboard.php">Panel de Administración</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h2>Registro de Producto</h2>
            <form method="POST" action="admin_add_product.php">
                <input type="text" name="nombre_producto" placeholder="Nombre del Producto" required>
                <textarea name="descripcion" placeholder="Descripción" required></textarea>
                <input type="number" step="0.01" name="precio" placeholder="Precio" required>
                <label>
                    <input type="checkbox" name="disponible" checked> Disponible
                </label>
                <button type="submit">Agregar Producto</button>
            </form>
        </div>
    </main>
 
    <script src="script.js"></script>
</body>
</html>
