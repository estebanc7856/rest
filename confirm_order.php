<?php
include 'db.php';
session_start();

if ($_SESSION['rol'] != 'cliente') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}

if (!isset($_POST['cantidad'])) {
    header("Location: order.php");
    exit;
}

$pedido_temp = $_POST['cantidad'];
$id_usuario = $_SESSION['usuario_id'];
$total = 0;

// Iniciar la transacción
$conn->begin_transaction();

try {
    // Crear una nueva orden
    $sql = "INSERT INTO ordenes (id_usuario, total) VALUES ('$id_usuario', 0)";
    if ($conn->query($sql) === TRUE) {
        $id_orden = $conn->insert_id;

        foreach ($pedido_temp as $id_producto => $cantidad) {
            $cantidad = (int)$cantidad;
            if ($cantidad > 0) {
                $result = $conn->query("SELECT precio, disponible FROM productos WHERE id = $id_producto");
                $producto = $result->fetch_assoc();

                if ($producto['disponible']) {
                    $precio_total = $producto['precio'] * $cantidad;
                    $total += $precio_total;
                    $conn->query("INSERT INTO orden_detalles (id_orden, id_producto, cantidad, precio) VALUES ($id_orden, $id_producto, $cantidad, $precio_total)");
                }
            }
        }

        // Actualizar el total de la orden
        $conn->query("UPDATE ordenes SET total = $total WHERE id = $id_orden");

        // Confirmar la transacción
        $conn->commit();

        // Limpiar la sesión del pedido temporal
        unset($_SESSION['pedido_temp']);

        header("Location: receipt.php?id_orden=$id_orden");
    } else {
        throw new Exception("Error al crear la orden: " . $conn->error);
    }
} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error al procesar el pedido: " . $e->getMessage();
}
?>
