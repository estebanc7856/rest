<?php
include 'db.php';
session_start();

if ($_SESSION['rol'] != 'admin') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Linguinni</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Panel de Administración</h1>
            <nav>
                <ul>
                    <li><a href="admin_add_product.php">Agregar Producto</a></li>
                    <li><a href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <h2>Bienvenido, Administrador</h2>
        <p>Desde aquí puedes gestionar los productos del restaurante.</p>

        <section>
            <h3>Menú de Productos</h3>
            <?php
            // Mostrar productos
            $sql = "SELECT * FROM productos";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<thead>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Disponible</th><th>Acciones</th></tr>";
                echo "</thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['nombre_producto'] . "</td>";
                    echo "<td>" . $row['descripcion'] . "</td>";
                    echo "<td>$" . $row['precio'] . "</td>";
                    echo "<td>" . ($row['disponible'] ? "Sí" : "No") . "</td>";
                    echo "<td>";
                    echo "<a href='admin_edit_product.php?id=" . $row['id'] . "'>Editar</a> | ";
                    echo "<a href='admin_delete_product.php?id=" . $row['id'] . "' onclick=\"return confirm('¿Estás seguro de eliminar este producto?');\">Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }
            ?>
        </section>
    </main>
   
    <script src="script.js"></script>
</body>
</html>
