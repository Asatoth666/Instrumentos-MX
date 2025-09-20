<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // 1️⃣ Validar formato de correo
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div style='color:red;'>Formato de correo inválido.</div>";
        exit;
    }

    // 2️⃣ Buscar usuario en la base de datos
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // 3️⃣ Verificar contraseña
        if (password_verify($password, $usuario['contrasena'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];

            // Login exitoso → redirigir a bienvenida.php
            header("Location: bienvenida.php");
            exit;
        } else {
            echo "<div style='color:red;'>Contraseña incorrecta.</div>";
        }
    } else {
        echo "<div style='color:red;'>No existe un usuario con ese correo.</div>";
    }
}
?>
