<?php
include 'conexion.php'; // conexión a la BD
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Verificar si el correo existe en la tabla usuarios
    $sql = "SELECT id, nombre FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $token = bin2hex(random_bytes(16)); // generar token seguro
        $expira = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Guardar token en la BD
        $sql_update = "UPDATE usuarios SET token_recuperacion=?, expira_token=? WHERE id=?";
        $stmt2 = $conn->prepare($sql_update);
        $stmt2->bind_param("ssi", $token, $expira, $usuario['id']);
        $stmt2->execute();

        // Enviar correo (requiere que XAMPP tenga configurado mail o usar PHPMailer)
        $enlace = "http://localhost/InstrumentosMX/restablecer.php?token=$token";
        $asunto = "Recuperación de contraseña - InstrumentosMX";
        $mensaje = "Hola " . $usuario['nombre'] . ",\n\nHaz clic en el siguiente enlace para restablecer tu contraseña:\n$enlace\n\nEste enlace expira en 1 hora.";
        $cabeceras = "From: no-reply@instrumentosmx.com";

        if (mail($email, $asunto, $mensaje, $cabeceras)) {
            echo "📧 Se ha enviado un enlace de recuperación a tu correo.";
        } else {
            echo "⚠️ No se pudo enviar el correo. Configura PHPMailer o SMTP.";
        }

    } else {
        echo "❌ El correo no está registrado.";
    }
}
?>
