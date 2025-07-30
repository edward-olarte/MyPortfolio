<?php
session_start();
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] !== 'admin') {
    header("Location: login.php");
    exit;
}

include("config/db.php");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    // Obtener nombre del archivo para eliminarlo del sistema de archivos
    $stmt = $conexion->prepare("SELECT nombre_archivo FROM archivos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre_archivo);
    if ($stmt->fetch()) {
        $ruta = "archivos/" . $nombre_archivo;
        if (file_exists($ruta)) {
            unlink($ruta); // Eliminar archivo físico
        }
    }
    $stmt->close();

    // Eliminar de la base de datos
    $stmt = $conexion->prepare("DELETE FROM archivos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: archivos.php");
exit;
