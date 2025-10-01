<?php
session_start();
include("conexion.php");

// Consultar todos los instrumentos con el nombre de la categoría
$sql = "SELECT i.*, c.nombre AS categoria
        FROM instrumentos i
        LEFT JOIN categorias c ON i.categoria_id = c.id
        ORDER BY i.nombre ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instrumentos - InstrumentosMX</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .productos-container { display:flex; flex-wrap:wrap; gap:20px; margin-top:20px; }
        .producto-card { border:1px solid #ccc; border-radius:10px; padding:15px; width:200px; text-align:center; background:#fff; box-shadow:0 0 10px rgba(0,0,0,0.1);}
        .producto-card img { width:100%; height:150px; object-fit:cover; border-radius:5px; }
        .producto-card button { margin-top:10px; padding:5px 10px; background:#007BFF; color:white; border:none; border-radius:5px; cursor:pointer; }
        .producto-card button:hover { background:#0056b3; }
    </style>
</head>
<body>
    <header>
        <h1>Catálogo de Instrumentos</h1>
        <nav>
            <a href="index.html" class="btn">Inicio</a>
            <a href="bienvenida.php" class="btn">Mi Perfil</a>
        </nav>
    </header>

    <div class="productos-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($p = $result->fetch_assoc()): ?>
                <div class="producto-card">
                    <?php if(!empty($p['imagen'])): ?>
                        <img src="img/<?php echo $p['imagen']; ?>" alt="<?php echo $p['nombre']; ?>">
                    <?php else: ?>
                        <img src="img/default.png" alt="Sin imagen">
                    <?php endif; ?>
                    <h3><?php echo $p['nombre']; ?></h3>
                    <p><b>Categoría:</b> <?php echo $p['categoria']; ?></p>
                    <p><b>Precio:</b> $<?php echo number_format($p['precio'],2); ?></p>
                    <p><b>Stock:</b> <?php echo $p['stock']; ?></p>
                    <button class="btn">Agregar al carrito</button>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay instrumentos disponibles en este momento</p>
        <?php endif; ?>
    </div>
</body>
</html>
