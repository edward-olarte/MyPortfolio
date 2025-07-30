<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$esAdmin = isset($_SESSION["usuario_rol"]) && $_SESSION["usuario_rol"] === "admin";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #434343, #1d618fff);
            color: #fff;
        }
        .encabezado {
            text-align: center;
            padding: 2rem;
            background-color: #1a1a1a;
            color: white;
        }
        .encabezado h1 {
            margin: 0;
            font-size: 2.5rem;
        }
        .encabezado p {
        font-style: italic;
        color: #ccc;
        }


        header {
            background-color: #2c3e50;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
        }

        .container {
            padding: 30px;
        }

        .admin-panel {
            background-color: #1f1f1f;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.4);
            margin-top: 20px;
        }

        .admin-panel h2 {
            margin-top: 0;
            color: #f39c12;
        }

        .admin-options {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: #2c3e50;
            padding: 20px;
            border-radius: 10px;
            flex: 1 1 200px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.3);
            text-align: center;
            transition: transform 0.2s ease;
            text-decoration: none;
            color: #ecf0f1;
        }

        .card:hover {
            transform: scale(1.05);
            background-color: #34495e;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .logout {
            display: block;
            text-align: center;
            margin-top: 30px;
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
        }

        .logout:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header class="encabezado">
  <h1>Edward | Programador Web</h1>
  <p>“Código claro, resultados duraderos”</p>
</header>


<div class="container">
    <p>Bienvenido, <?= $esAdmin ? 'Administrador' : 'Usuario' ?>.</p>

    <?php if ($esAdmin): ?>
        <div class="admin-panel">
            <h2>Vista de Administrador</h2>
            <div class="admin-options">
                <a href="usuarios.php" class="card">
                    <h3>👥 Gestionar Usuarios</h3>
                    <p>Ver, editar o eliminar cuentas.</p>
                </a>
                <a href="archivos.php" class="card">
                    <h3>📂 Subidas de PDF</h3>
                    <p>Revisar, descargar o eliminar archivos.</p>
                </a>
                <a href="estadisticas.php" class="card">
                    <h3>📊 Estadísticas</h3>
                    <p>Ver actividad reciente y gráficos.</p>
                </a>
                <a href="configuracion.php" class="card">
                    <h3>⚙️ Configuración</h3>
                    <p>Actualizar parámetros del sistema.</p>
                </a>
            </div>
        </div>
    <?php else: ?>
        <p>No tienes permisos de administrador.</p>
    <?php endif; ?>

    <a class="logout" href="logout.php">Cerrar sesión</a>
</div>

</body>
</html>
