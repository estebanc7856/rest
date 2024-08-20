<?php
include 'db.php';
session_start();

if ($_SESSION['rol'] != 'cliente') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Realizar Pedido</h1>
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
            <h2>Selecciona los productos</h2>
            <form method="POST" action="order_process.php">
                <div class="products-list">
                    <?php
                    $sql = "SELECT * FROM productos";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                        $checked = $row['disponible'] ? '' : 'disabled';
                        echo "<div class='product-item'>";
                        echo "<label>";
                        echo $row['nombre_producto'] . " ($" . $row['precio'] . ")";
                        echo "<input type='checkbox' name='productos[".$row['id']."]' value='1' $checked> ";
                        echo "<input type='number' name='cantidad[".$row['id']."]' min='1' value='1' style='width: 60px;' $checked> ";
                        echo "</label>";
                        echo "</div>";
                    }
                    ?>
                </div>
                <button type="submit">Revisar Pedido</button>
            </form>
        </div>
    </main>
   
    <script src="script.js"></script>
</body>
</html>
