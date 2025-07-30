<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

include("config/db.php");

$id = $_GET["id"];
$usuario_id = $_SESSION["usuario_id"];

$stmt = $conexion->prepare("SELECT nombre_archivo FROM archivos WHERE id = ? AND usuario_id = ?");
$stmt->bind_param("ii", $id, $usuario_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($nombre_archivo);
    $stmt->fetch();
    unlink("uploads/" . $nombre_archivo);

    $conexion->query("DELETE FROM archivos WHERE id = $id");
}
header("Location: dashboard.php");
