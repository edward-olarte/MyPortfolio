<?php
session_start();

if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] !== 'admin') {
    header("Location: login.php");
    exit;
}

include("config/db.php");

if ($_FILES["archivo"]["type"] === "application/pdf") {
    $nombre_original = $_FILES["archivo"]["name"];
    $nombre_guardado = uniqid() . ".pdf";
    $ruta = "archivos/" . $nombre_guardado;

    // Verifica y crea carpeta si no existe
    if (!is_dir("archivos")) {
        mkdir("archivos", 0777, true);
    }

    if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta)) {
        $stmt = $conexion->prepare("INSERT INTO archivos (nombre_original, nombre_archivo, usuario_id, fecha_subida) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("ssi", $nombre_original, $nombre_guardado, $_SESSION["usuario_id"]);
        $stmt->execute();
    }
}

header("Location: archivos.php");
exit;
