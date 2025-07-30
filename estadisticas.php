<?php
session_start();
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] !== "admin") {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estadísticas</title>
    <style>
        body { background: #1e1e1e; color: white; font-family: sans-serif; padding: 40px; }
        h1 { color: #2ecc71; }
        a { color: #ecf0f1; text-decoration: underline; }
    </style>
</head>
<body>
    <h1>📊 Estadísticas de Uso</h1>
    <p>Próximamente: gráficas y reportes de actividad del sistema.</p>
    <a href="dashboard.php">← Volver al panel</a>
</body>
</html>
