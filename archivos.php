<?php
session_start();
if (!isset($_SESSION["usuario_id"]) || $_SESSION["usuario_rol"] !== 'admin') {
    header("Location: login.php");
    exit;
}

include("config/db.php");

$resultado = $conexion->query("SELECT * FROM archivos ORDER BY fecha_subida DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Archivos PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #17599bff;
        }

        .encabezado {
            text-align: center;
            margin-bottom: 30px;
            background: #0b3c6a;
            padding: 20px;
            border-radius: 10px;
            color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .encabezado h1 {
            margin: 0;
            font-size: 2.2rem;
            font-weight: bold;
        }

        .encabezado .lema {
            margin-top: 10px;
            font-style: italic;
            font-size: 1.1rem;
            color: #dcdcdc;
        }

        .upload-form {
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        input[type="file"] {
            padding: 10px;
            margin-right: 10px;
        }

        button {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        .contenedor-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .card.moderna {
            position: relative;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card.moderna:hover {
            transform: translateY(-8px);
        }

        .card-cabecera {
            position: relative;
            height: 80px;
            background: linear-gradient(135deg, #f39c12, #f1c40f);
            clip-path: polygon(50% 0%, 100% 0%, 100% 100%, 85% 100%);
        }

        .icono-destacado {
            position: absolute;
            top: 15px;
            right: 20px;
            background: white;
            color: #f39c12;
            font-size: 1.2rem;
            font-weight: bold;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-body {
            padding: 20px;
            text-align: center;
        }

        .card-body h3 {
            font-size: 1.1rem;
            color: #333;
            margin: 0;
        }

        .card-body p {
            font-size: 0.9rem;
            color: #777;
            margin: 10px 0;
        }

        .acciones {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: center;
            margin-top: 15px;
        }

        .btn-principal {
            background-color: #f39c12;
            color: white;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 20px;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .btn-principal:hover {
            background-color: #e67e22;
        }

        .btn-secundario {
            background-color: #ecf0f1;
            color: #2c3e50;
            text-decoration: none;
            padding: 8px 14px;
            border-radius: 20px;
            font-weight: bold;
            transition: background-color 0.2s;
        }



        .btn-secundario:hover {
            background-color: #bdc3c7;
        }


        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        .a {
            color: #08090aff;
            text-decoration: none;
        }

        .acciones a {
            margin: 0 5px;
            text-decoration: none;
            font-weight: bold;
            color: #e74c3c;
        }

        .acciones a:hover {
            text-decoration: underline;
        }

        .sobre-mi {
            margin-top: 40px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .sobre-mi h2 {
            margin-top: 0;
            color: #0b3c6a;
        }
        .cv {
            margin: 40px auto;
            max-width: 500px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            border: 2px solid transparent;
            transition: border 0.5s, box-shadow 0.5s;
        }

        .cv:hover {
            border: 2px solid #f39c12;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .cv::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(60deg, #f39c12, #f1c40f, #f39c12);
            animation: rotarBorde 4s linear infinite;
            z-index: -1;
            opacity: 0.1;
        }

        @keyframes rotarBorde {
            from {
                transform: rotate(0deg);
            } to {
                transform: rotate(360deg);
            }
        }

        .cv h2 {
            color: #0b3c6a;
            margin-bottom: 15px;
        }

        .cv p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 20px;
        }

        .boton-cv {
            display: inline-block;
            background-color: #f39c12;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .boton-cv:hover {
            background-color: #e67e22;
        }


        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9rem;
            color: #f0f0f0;
        }
    </style>
</head>
<body>

<header class="encabezado">
    <h1>Edward | Programador Web</h1>
    <p class="lema">“Código claro, resultados duraderos”</p>
</header>

<?php if ($_SESSION["usuario_rol"] === 'admin'): ?>
<div class="upload-form">
    <form action="subir.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="archivo" accept=".pdf" required>
        <button type="submit">Subir PDF</button>
    </form>
</div>
<?php endif; ?>

<div class="contenedor-cards">
    <?php 
    $contador = 1;
    while ($fila = $resultado->fetch_assoc()): 
    ?>
    <div class="card moderna">
        <div class="card-cabecera">
            <div class="icono-destacado">
                <?= $contador++ ?>
            </div>
        </div>
        <div class="card-body">
            <h3><?= htmlspecialchars($fila["nombre_original"]) ?> (Sesión <?= $fila["id"] ?>)</h3>
            <p>📅 <?= $fila["fecha_subida"] ?></p>
            <div class="acciones">
                <a href="archivos/<?= $fila["nombre_archivo"] ?>" class="btn-principal" target="_blank">👁️ Ver</a>
                <a href="descargas.php?id=<?= $fila["id"] ?>" class="btn-principal">📥 Descargar</a>
                <a href="editar.php?id=<?= $fila["id"] ?>" class="btn-secundario">✏️ Editar</a>
                <a href="eliminar.php?id=<?= $fila["id"] ?>" class="btn-secundario" onclick="return confirm('¿Eliminar archivo?')">🗑️ Eliminar</a>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</div>




<!-- Sección Sobre mí -->
<section class="sobre-mi">
    <h2>Sobre mí</h2>
    <p>
        Soy Edward, desarrollador web con enfoque en soluciones precisas, seguras y funcionales. Cada línea de código en este proyecto fue escrita con atención al detalle y buscando simplicidad elegante. Este portafolio es mi carta de presentación profesional.
    </p>
</section>
<section class="cv">
    <h2>📌 Mi CV</h2>
    <p>Puedes descargar mi currículum profesional en formato PDF:</p>
    <a class="boton-cv" href="archivos/CV.pdf" download>📄 Descargar CV</a>
</section>


<div class="footer">
    Desarrollado por Edward - 2025
</div>

<a href="dashboard.php">← Volver al panel</a>

</body>
</html>