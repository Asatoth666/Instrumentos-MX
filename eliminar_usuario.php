<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}
include("conexion.php");

$id = $_GET['id'] ?? null;
if ($id) {
    // Evitar que el admin se elimine a sí mismo
    if ($id != $_SESSION['usuario_id']) {
        $conn->query("DELETE FROM usuarios WHERE id=$id");
    }
}
header("Location: admin_panel.php");
exit;
?>
