<?php
$host = "localhost"; 
$user = "root";      // cambia si usas otro usuario en MySQL
$pass = "";          // coloca tu contraseña de MySQL
$db   = "instrumentos_db";

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
