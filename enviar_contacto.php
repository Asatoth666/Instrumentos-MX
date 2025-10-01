<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $mensaje = $_POST['mensaje'];

    // Aquí podrías enviar el mensaje a tu correo (mail()) o guardarlo en la BD
    echo "<p style='color:green;'>Gracias $nombre, hemos recibido tu mensaje y te responderemos pronto.</p>";
    echo "<a href='contacto.html'>Volver</a>";
}
?>
