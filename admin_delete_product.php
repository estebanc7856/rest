<?php
include 'db.php';
session_start();

if ($_SESSION['rol'] != 'admin') {
    echo "No tienes permisos para acceder a esta página.";
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM productos WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
    } else {
        echo "Error al eliminar el producto: " . $conn->error;
    }
} else {
    echo "ID de producto no proporcionado.";
    exit;
}
?>
