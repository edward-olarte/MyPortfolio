<?php
session_start();
include("config/db.php");

$mensaje_error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $password = $_POST["password"];

    // Ahora también se obtiene el rol
    $stmt = $conexion->prepare("SELECT id, password, rol FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hash, $rol);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION["usuario_id"] = $id;
            $_SESSION["usuario_rol"] = $rol; // guardamos el rol

            if ($rol === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: archivos.php");
            }
            exit;
        } else {
            $mensaje_error = "⚠️ Contraseña incorrecta.";
        }
    } else {
        $mensaje_error = "⚠️ Correo no encontrado.";
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #434343, #16618dff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #2c3e50;
        }

        label {
            font-weight: bold;
            color: #2c3e50;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
        }

        button {
            width: 100%;
            background-color: #06032cff;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        .registro-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #2c3e50;
            text-decoration: none;
        }

        .registro-link:hover {
            text-decoration: underline;
        }

        .error {
            color: #e74c3c;
            background-color: #fdd;
            padding: 10px;
            border: 1px solid #e74c3c;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Iniciar Sesión</h2>

    <?php if (!empty($mensaje_error)): ?>
        <div class="error"><?= $mensaje_error ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" id="correo" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Ingresar</button>
    </form>
    <a class="registro-link" href="registro.php">¿No tienes cuenta? Regístrate</a>
</div>

</body>
</html>
