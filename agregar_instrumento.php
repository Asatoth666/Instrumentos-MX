<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}
include("conexion.php");

// Carpeta donde se guardarán las imágenes
$targetDir = "img/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $categoria_id = (int)$_POST['categoria_id'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    $imagen = ''; // Inicialmente vacío

    // Manejar subida de archivo
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagen']['tmp_name'];
        $fileName = basename($_FILES['imagen']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Validar extensión de archivo
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExt, $allowedExt)) {
            $newFileName = time() . "_" . $fileName; // Nombre único
            $dest_path = $targetDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagen = $newFileName; // Guardar el nombre para BD
            } else {
                echo "<p style='color:red;'>Error al mover el archivo.</p>";
            }
        } else {
            echo "<p style='color:red;'>Formato de imagen no permitido. Solo JPG, PNG, GIF.</p>";
        }
    }

    // Insertar en la BD
    $sql = "INSERT INTO instrumentos (nombre, categoria_id, precio, stock, imagen) 
            VALUES ('$nombre', $categoria_id, '$precio', '$stock', '$imagen')";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_panel.php");
        exit;
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}

// Obtener categorías para el select
$categorias = $conn->query("SELECT id, nombre FROM categorias ORDER BY nombre ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Instrumento - Admin</title>
    <link rel="stylesheet" href="css/style.css">
   
</head>
<body>
    <h2>Agregar Instrumento 🎸</h2>
    <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" required>

        <label>Categoría:</label>
        <select name="categoria_id" required>
            <option value="">-- Selecciona una categoría --</option>
            <?php while($c = $categorias->fetch_assoc()): ?>
                <option value="<?php echo $c['id']; ?>"><?php echo $c['nombre']; ?></option>
            <?php endwhile; ?>
        </select>

        <label>Precio:</label>
        <input type="number" step="0.01" name="precio" required>

        <label>Stock:</label>
        <input type="number" name="stock" required>

        <label>Imagen:</label>
        <input type="file" name="imagen" accept=".jpg,.jpeg,.png,.gif">

        <button type="submit" class="btn">Guardar</button>
        <a href="admin_panel.php" class="btn-warning">Cancelar</a>
    </form>
</body>
</html>
