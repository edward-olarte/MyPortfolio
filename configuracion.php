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
    <title>Configuración</title>
    <style>
        body { background: #502121ff; color: white; font-family: sans-serif; padding: 40px; }
        h1 { color: #000000ff; text-align: center;}
        a { color: #070a0aff; text-decoration: underline; }
    </style>
</head>
<body>
    <h1>⚙️ Configuración del Sistema</h1>
    <p>Aquí podrás cambiar parámetros generales más adelante.</p>
    <a href="dashboard.php">← Volver al panel</a>
</body>
</html>
