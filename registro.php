
<?php
session_start();
include("conexion.php");

$error = "";
$exito = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre    = trim($_POST['nombre']);
    $apellidoP = trim($_POST['apellidoP']);
    $apellidoM = trim($_POST['apellidoM']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];

    // Validaciones
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "❌ Correo inválido.";
    } elseif (strlen($password) < 6 || !preg_match("/[0-9]/", $password)) {
        $error = "❌ La contraseña debe tener al menos 6 caracteres y un número.";
    } else {
        // Verificar si el correo existe
        $sql_check = "SELECT * FROM usuarios WHERE email='$email'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            $error = "❌ El correo ya está registrado.";
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nombre, apellidoP, apellidoM, email, contrasena)
                    VALUES ('$nombre', '$apellidoP', '$apellidoM', '$email', '$password_hash')";

            if ($conn->query($sql) === TRUE) {
                $exito = "✅ Registro exitoso. Redirigiendo a inicio de sesión...";
                // Redirigir después de 3 segundos
                header("refresh:3;url=login.html");
            } else {
                $error = "❌ Error al registrar: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - InstrumentosMX</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .mensaje { text-align:center; margin-bottom: 15px; font-weight:bold; }
        .error { color: #d8000c; background-color: #ffbaba; padding: 10px; border-radius: 5px; }
        .exito { color: #155724; background-color: #d4edda; padding: 10px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Crear cuenta</h2>

        <!-- Mensajes de error o éxito -->
        <?php if($error): ?>
            <div class="mensaje error"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($exito): ?>
            <div class="mensaje exito"><?php echo $exito; ?></div>
        <?php endif; ?>

        <form action="registro.php" method="POST">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="apellidoP">Apellido Paterno</label>
            <input type="text" id="apellidoP" name="apellidoP" required>

            <label for="apellidoM">Apellido Materno</label>
            <input type="text" id="apellidoM" name="apellidoM" required>

            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login.html">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
