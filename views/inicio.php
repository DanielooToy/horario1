

<?php
session_start();
error_reporting(0);

$validar = $_SESSION['nombre'];

if ($validar == null || $validar == '') {
    header("Location: ../includes/login.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <style>
     body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        
        .bgvideo {
    position: fixed;
    right: -6%;  
    bottom: 7%; 
    width: 60%;  
    height: 60%; 
    object-fit: contain;  /* Cambia esto para ajustar el video dentro del contenedor */
}
        footer {
            background-color: #2f2c79;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

    </style>
</head>
<body>
    <header id="header" style="background-color: #2f2c79; color: #fff; text-align: center; padding: 20px 0;">
    <h1>Bienvenido a tu Sistema de Gestión Escolar <?php echo $_SESSION['nombre']; ?></h1>
    </header>


    <nav id="nav">
        <ul style="list-style-type: none; margin: 0; padding: 0; overflow: hidden; background-color: #2f2c79;">
            <li style="float: left;"><a href="../views/inicio.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Inicio</a></li>
            <li style="float: left;"><a href="../horariosup/crearhorarios.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Crear Horario</a></li>
            <li style="float: left;"><a href="../horariosup/horarios_guardados.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Horarios Guardados</a></li>
            <li style="float: left;"><a href="../materiasid/materias_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Materias</a></li>
            <li style="float: left;"><a href="../maestrosid/maestros_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Maestros</a></li>
            <li style="float: left;"><a href="../gruposid/grupos_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Grupos</a></li>
            <li style="float: left;"><a href="../salonesid/salones_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Salones</a></li>
            <li style="float: left;"><a href="../views/user.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Administrar usuarios</a></li>
            <li style="float: left;"><a href="../includes/_sesion/cerrarSesion.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Cerrar Sesión<i class="fa fa-power-off" aria-hidden="true"></i></a> </li>
        </ul>
    </nav>

    <video autoplay loop muted class="bgvideo" id="bgvideo">
        <source src="../images/video_inicio.mp4" type="video/mp4">
    </video>


    <footer>
        <p>&copy; 2024 Sistema de Gestión Escolar Héctor Darío Maya Aguilar</p>
    </footer>
</body>
</html>
