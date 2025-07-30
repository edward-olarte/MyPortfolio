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
    <title>Gestión de Usuarios</title>
    <style>
        body { 
            background: #3382a1ff; 
            color: white; 
            font-family: sans-serif; 
            padding: 40px; 
        }
        h1 { 
            color: #f1c40f;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            text-align: center;
        }
        a { 
            color: #ecf0f1; 
            text-decoration: underline;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

    </style>
</head>
<body>
    <h1>👥 Gestión de Usuarios</h1>
    <p>Aquí puedes ver, editar o eliminar usuarios.</p>
    <a href="dashboard.php">← Volver al panel</a>
</body>
</html>