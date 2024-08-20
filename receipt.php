<?php
include 'db.php';
session_start();

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'cliente') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}

if (!isset($_GET['id_orden'])) {
    echo "ID de orden no proporcionado.";
    exit;
}

$id_orden = $_GET['id_orden'];
$sql = "SELECT * FROM ordenes WHERE id = $id_orden";
$orden_result = $conn->query($sql);

if ($orden_result->num_rows == 0) {
    echo "Orden no encontrada.";
    exit;
}

$orden = $orden_result->fetch_assoc();
$sql_detalles = "SELECT p.nombre_producto, od.cantidad, od.precio FROM orden_detalles od JOIN productos p ON od.id_producto = p.id WHERE od.id_orden = $id_orden";
$detalles = $conn->query($sql_detalles);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $dinero_ingresado = $_POST['dinero_ingresado'];
    $cambio = $dinero_ingresado - $orden['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Recibo</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="receipt-container">
            <h2>Detalles de la Orden #<?php echo $id_orden; ?></h2>
            <table>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
                <?php while ($detalle = $detalles->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $detalle['nombre_producto']; ?></td>
                    <td><?php echo $detalle['cantidad']; ?></td>
                    <td>$<?php echo $detalle['precio']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
            <p>Total: $<?php echo $orden['total']; ?></p>
            <form method="POST" action="receipt.php?id_orden=<?php echo $id_orden; ?>">
                <label for="dinero_ingresado">Dinero Ingresado:</label>
                <input type="number" name="dinero_ingresado" step="0.01" required>
                <button type="submit">Calcular Cambio</button>
            </form>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
            <p>Cambio: $<?php echo number_format($cambio, 2); ?></p>
            <?php endif; ?>
        </div>
    </main>
    
    <script src="script.js"></script>
</body>
</html>
