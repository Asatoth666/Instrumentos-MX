<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO instrumentos (nombre, categoria, precio, stock) 
            VALUES ('$nombre', '$categoria', '$precio', '$stock')";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Instrumento</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Agregar Instrumento 🎸</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label>Categoría:</label>
        <input type="text" name="categoria" required><br>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required><br>

        <label>Stock:</label>
        <input type="number" name="stock" required><br>

        <button type="submit" class="btn">Guardar</button>
        <a href="admin_panel.php" class="btn btn-warning">Cancelar</a>
    </form>
</body>
</html>
