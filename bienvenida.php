<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.html");
    exit;
}

include("conexion.php");

$id = $_SESSION['usuario_id'];
$sql = "SELECT nombre, apellidoP, apellidoM, email, fecha_registro FROM usuarios WHERE id='$id'";
$result = $conn->query($sql);
$usuario = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido - InstrumentosMX</title>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <div class="perfil">
        <h2>Bienvenido, <?php echo $usuario['nombre']; ?> 🎸</h2>
        <p class="info"><b>Nombre completo:</b> <?php echo $usuario['nombre'] . " " . $usuario['apellidoP'] . " " . $usuario['apellidoM']; ?></p>
        <p class="info"><b>Correo:</b> <?php echo $usuario['email']; ?></p>
        <p class="info"><b>Miembro desde:</b> <?php echo date("d-m-Y", strtotime($usuario['fecha_registro'])); ?></p>

        <a href="logout.php" class="btn">Cerrar sesión</a>
    </div>
</body>
</html>
