<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}

include("conexion.php");

// Consultar usuarios
$usuarios = $conn->query("SELECT id, nombre, email, rol FROM usuarios");

// Consultar productos
$instrumentos = $conn->query("
    SELECT i.id, i.nombre, i.precio, i.stock, c.nombre AS categoria
    FROM instrumentos i
    LEFT JOIN categorias c ON i.categoria_id = c.id
");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - InstrumentosMX</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: Arial, sans-serif; padding:20px; }
        h2 { margin-top:30px; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { padding:8px; border:1px solid #ccc; text-align:center; }
        th { background:#f4f4f4; }
        .btn { padding:5px 10px; background:#007BFF; color:white; text-decoration:none; border-radius:5px; }
        .btn-danger { background:#dc3545; }
        .btn-warning { background:#ffc107; color:black; }
    </style>
</head>
<body>
    <h1>Bienvenido Admin, <?php echo $_SESSION['nombre']; ?> 🎩</h1>
    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>

    <h2>👤 Usuarios</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Acciones</th>
        </tr>
        <?php while($u = $usuarios->fetch_assoc()): ?>
        <tr>
            <td><?php echo $u['id']; ?></td>
            <td><?php echo $u['nombre']; ?></td>
            <td><?php echo $u['email']; ?></td>
            <td><?php echo $u['rol']; ?></td>
            <td>
                <a href="editar_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-warning">Editar</a>
                <a href="eliminar_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <h2>🎸 Instrumentos</h2>
<a href="agregar_instrumento.php" class="btn">Agregar Instrumento</a>
<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Categoría</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
    </tr>
    <?php while($i = $instrumentos->fetch_assoc()): ?>
    <tr>
        <td><?php echo $i['id']; ?></td>
        <td><?php echo $i['nombre']; ?></td>
        <td><?php echo $i['categoria']; ?></td>
        <td>$<?php echo number_format($i['precio'],2); ?></td>
        <td><?php echo $i['stock']; ?></td>
        <td>
            <a href="editar_instrumento.php?id=<?php echo $i['id']; ?>" class="btn btn-warning">Editar</a>
            <a href="eliminar_instrumento.php?id=<?php echo $i['id']; ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>