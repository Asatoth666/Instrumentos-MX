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
    $email = $_POST['email'];
    $rol = $_POST['rol'];

    $sql = "UPDATE usuarios SET nombre='$nombre', email='$email', rol='$rol' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

$result = $conn->query("SELECT * FROM usuarios WHERE id=$id");
$usuario = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Editar Usuario 👤</h2>
    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required><br>

        <label>Rol:</label>
        <select name="rol" required>
            <option value="usuario" <?php if($usuario['rol']=="usuario") echo "selected"; ?>>Usuario</option>
            <option value="admin" <?php if($usuario['rol']=="admin") echo "selected"; ?>>Administrador</option>
        </select><br>

        <button type="submit" class="btn">Actualizar</button>
        <a href="admin_panel.php" class="btn btn-warning">Cancelar</a>
    </form>
</body>
</html>
