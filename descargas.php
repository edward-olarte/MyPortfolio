<?php
session_start();
if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

include("config/db.php");

$resultado = $conexion->query("SELECT id, nombre_original, fecha_subida FROM archivos ORDER BY fecha_subida DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Descargas</title>
</head>
<body>
    <h2>Archivos Disponibles para Descargar</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Archivo</th>
                <th>Fecha</th>
                <th>Descargar</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre_original']) ?></td>
                <td><?= $fila['fecha_subida'] ?></td>
                <td><a href="download.php?id=<?= $fila['id'] ?>">📥 Descargar</a></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
