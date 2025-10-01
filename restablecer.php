<?php
include 'conexion.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validar token
    $sql = "SELECT id, expira_token FROM usuarios WHERE token_recuperacion=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar que no haya expirado
        if (strtotime($usuario['expira_token']) > time()) {
            ?>
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <title>Restablecer Contraseña</title>
                <link rel="stylesheet" href="css/style.css">
            </head>
            <body>
                <div class="login-container">
                    <h2>Restablecer Contraseña</h2>
                    <form action="restablecer_guardar.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                        <label for="password">Nueva Contraseña</label>
                        <input type="password" name="password" required>
                        <button type="submit" class="btn">Guardar</button>
                    </form>
                </div>
            </body>
            </html>
            <?php
        } else {
            echo "❌ El enlace ha expirado.";
        }
    } else {
        echo "❌ Token inválido.";
    }
}
?>
