<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios SET password=?, token_recuperacion=NULL, expira_token=NULL WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $password, $id);

    if ($stmt->execute()) {
        echo "✅ Contraseña actualizada con éxito. <a href='login.html'>Iniciar sesión</a>";
    } else {
        echo "❌ Error al actualizar la contraseña.";
    }
}
?>
