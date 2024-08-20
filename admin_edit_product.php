<?php
include 'db.php';
session_start();

if ($_SESSION['rol'] != 'admin') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nombre_producto = $_POST['nombre_producto'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];
        $disponible = isset($_POST['disponible']) ? 1 : 0;

        $sql = "UPDATE productos SET nombre_producto='$nombre_producto', descripcion='$descripcion', precio='$precio', disponible='$disponible' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            header("Location: dashboard.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        $sql = "SELECT * FROM productos WHERE id=$id";
        $result = $conn->query($sql);
        $producto = $result->fetch_assoc();
    }
} else {
    echo "ID de producto no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Editar Producto</h1>
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
            <h2>Actualizar Producto</h2>
            <form method="POST" action="">
                <input type="text" name="nombre_producto" value="<?php echo $producto['nombre_producto']; ?>" placeholder="Nombre del Producto" required>
                <textarea name="descripcion" placeholder="Descripción" required><?php echo $producto['descripcion']; ?></textarea>
                <input type="number" step="0.01" name="precio" value="<?php echo $producto['precio']; ?>" placeholder="Precio" required>
                <label>
                    <input type="checkbox" name="disponible" <?php echo $producto['disponible'] ? 'checked' : ''; ?>> Disponible
                </label>
                <button type="submit">Actualizar Producto</button>
            </form>
        </div>
    </main>
    
    <script src="script.js"></script>
</body>
</html>
