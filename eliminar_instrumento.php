<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.html");
    exit;
}
include("conexion.php");

$id = $_GET['id'] ?? null;
if ($id) {
    $conn->query("DELETE FROM instrumentos WHERE id=$id");
}
header("Location: admin_panel.php");
exit;
?>
