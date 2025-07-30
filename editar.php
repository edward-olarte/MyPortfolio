<?php
session_start();

// Verificar si está logueado y es admin
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] !== 'admin') {
    header("Location: login.php");
    exit;
}

include("config/db.php");

$id = $_GET["id"];
$usuario_id = $_SESSION["usuario_id"];

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nuevo_nombre = $_POST["nombre"];
    $stmt = $conexion->prepare("UPDATE archivos SET nombre_original = ? WHERE id = ?");
    $stmt->bind_param("si", $nuevo_nombre, $id);
    $stmt->execute();
    header("Location: dashboard.php");
    exit;
}

// Obtener el nombre actual del archivo
$stmt = $conexion->prepare("SELECT nombre_original FROM archivos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($nombre_actual);
$stmt->fetch();
$stmt->close();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Nombre del Archivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">✏️ Renombrar archivo</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nuevo nombre</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" value="<?= htmlspecialchars($nombre_actual) ?>" required>
                        </div>
                        <button type="submit" class="btn btn-success">💾 Guardar cambios</button>
                        <a href="dashboard.php" class="btn btn-secondary ms-2">↩️ Volver</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
