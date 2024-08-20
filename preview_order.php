<?php
include 'db.php';
session_start();

if ($_SESSION['rol'] != 'cliente') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}

if (!isset($_SESSION['pedido_temp'])) {
    header("Location: order.php");
    exit;
}

$pedido_temp = $_SESSION['pedido_temp'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista Previa del Pedido - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Vista Previa del Pedido</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <div class="form-container">
            <h2>Revisa tu pedido</h2>
            <form method="POST" action="confirm_order.php">
                <div class="products-list">
                    <?php
                    foreach ($pedido_temp['productos'] as $id_producto => $valor) {
                        if ($valor == '1' && isset($pedido_temp['cantidad'][$id_producto])) {
                            $cantidad = (int)$pedido_temp['cantidad'][$id_producto];
                            if ($cantidad > 0) {
                                $sql = "SELECT * FROM productos WHERE id = $id_producto";
                                $result = $conn->query($sql);
                                $producto = $result->fetch_assoc();

                                echo "<div class='product-item'>";
                                echo "<label>";
                                echo $producto['nombre_producto'] . " ($" . $producto['precio'] . ")";
                                echo "<input type='number' name='cantidad[$id_producto]' min='1' value='$cantidad' style='width: 60px;'> ";
                                echo "</label>";
                                echo "</div>";
                            }
                        }
                    }
                    ?>
                </div>
                <button type="submit">Confirmar Pedido</button>
                <a href="order.php" class="button">Editar Pedido</a>
            </form>
        </div>
    </main>
    
    <script src="script.js"></script>
</body>
</html>
