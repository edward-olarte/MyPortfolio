<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

include("config/db.php");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $stmt = $conexion->prepare("SELECT nombre_archivo, nombre_original FROM archivos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($nombre_archivo, $nombre_original);

    if ($stmt->fetch()) {
        $ruta = "archivos/" . $nombre_archivo;

        if (file_exists($ruta)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $nombre_original . '"');
            header('Content-Length: ' . filesize($ruta));
            flush();
            readfile($ruta);
            exit;
        } else {
            echo "Archivo no encontrado.";
        }
    } else {
        echo "ID inválido.";
    }
    $stmt->close();
}
?>
