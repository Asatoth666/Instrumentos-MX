<?php
session_start();
include("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        if (password_verify($password, $usuario['contrasena'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol']; // << guardamos el rol

            // Si es admin lo mandamos al panel de administración
            if ($usuario['rol'] === 'admin') {
                header("Location: admin_panel.php");
            } else {
                header("Location: bienvenida.php");
            }
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "No existe un usuario con ese correo.";
    }
}
?>