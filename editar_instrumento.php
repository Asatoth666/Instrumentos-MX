<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}
include("conexion.php");

$id = $_GET['id'] ?? null;
if (!$id) { header("Location: admin_panel.php"); exit; }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $sql = "UPDATE instrumentos SET 
                nombre='$nombre', categoria='$categoria', 
                precio='$precio', stock='$stock' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM instrumentos WHERE id=$id");
$instrumento = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Instrumento</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Editar Instrumento 🎶</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $instrumento['nombre']; ?>" required><br>

        <label>Categoría:</label>
        <input type="text" name="categoria" value="<?php echo $instrumento['categoria']; ?>" required><br>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" value="<?php echo $instrumento['precio']; ?>" required><br>

        <label>Stock:</label>
        <input type="number" name="stock" value="<?php echo $instrumento['stock']; ?>" required><br>

        <button type="submit" class="btn">Actualizar</button>
        <a href="admin_panel.php" class="btn btn-warning">Cancelar</a>
    </form>
</body>
</html>
