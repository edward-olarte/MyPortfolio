<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre_original = $_FILES["archivo"]["name"];
    $tmp = $_FILES["archivo"]["tmp_name"];
    $usuario_id = $_SESSION["usuario_id"];

    $ext = pathinfo($nombre_original, PATHINFO_EXTENSION);
    if ($ext !== "pdf") {
        echo "Solo se permiten archivos PDF.";
        exit;
    }

    $nombre_unico = uniqid() . "_" . $nombre_original;
    $ruta = "uploads/" . $nombre_unico;

    if (move_uploaded_file($tmp, $ruta)) {
        $stmt = $conexion->prepare("INSERT INTO archivos (usuario_id, nombre_original, nombre_archivo) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $usuario_id, $nombre_original, $nombre_unico);
        $stmt->execute();
        header("Location: dashboard.php");
    } else {
        echo "Error al subir el archivo.";
    }
}
?>

<h2>Subir nuevo archivo PDF</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="archivo" accept=".pdf" required>
    <button type="submit">Subir</button>
</form>
