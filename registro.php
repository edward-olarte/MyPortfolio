<?php
include("config/db.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (correo, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $correo, $password);
    if ($stmt->execute()) {
        header("Location: login.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #2c3e50, #4ca1af);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
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
            box-sizing: border-box;
            transition: all 0.3s ease;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #4ca1af;
            box-shadow: 0 0 8px rgba(76, 161, 175, 0.3);
        }

        button {
            width: 100%;
            background-color: #0d0652ff;
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
            background-color: #57c7b4ff;
        }

        .login-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #2c3e50;
            text-decoration: none;
        }

        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Crear Cuenta</h2>
    <form method="POST">
        <label for="correo">Correo electrónico:</label>
        <input type="email" name="correo" id="correo" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required>

        <button type="submit">Registrarse</button>
    </form>
    <a class="login-link" href="login.php">¿Ya tienes cuenta? Inicia sesión</a>
</div>

</body>
</html>
