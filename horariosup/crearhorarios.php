<?php

session_start();
error_reporting(0);

$validar = $_SESSION['nombre'];

if( $validar == null || $validar = ''){

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
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #2f2c79;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }
        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #2f2c79;
        }
        nav ul li {
            float: left;
        }
        nav ul li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        nav ul li a:hover {
            background-color: #111;
        }
        main {
            padding: 20px;
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

       /* Estilos para el contenedor de los logos */
.container {
    /* Utiliza un contenedor flexible */
    display: flex;
    /* Centra los elementos secundarios horizontalmente */
    justify-content: center;
    /* Centra los elementos secundarios verticalmente */
    align-items: center; 
    /* Ajusta el margen superior para centrar verticalmente */
    margin-top: 200px; /* Ajusta según sea necesario */
    margin-bottom: 100px; /* Ajusta según sea necesario */
}

/* Estilos para cada logo */
.carrera {
    /* Espacio entre cada logo */
    margin: 50px;
}

/* Estilos para las imágenes de los logos */
.carrera img {
    /* Ancho fijo para los logos */
    width: 280px;
    /* Altura automática para mantener la proporción */
    height: auto;
    /* Hace que las imágenes se muestren como bloques */
    display: block;
    /* Transición suave de transformación */
    transition: transform 0.3s ease; /* Transición suave de 0.3 segundos */
}

/* Estilos para la animación de resaltado al pasar el cursor sobre la imagen */
.carrera img:hover {
    /* Hace la imagen 10% más grande al pasar el cursor sobre ella */
    transform: scale(1.1); 
}

        
    </style>
</head>
<body>
    <header>
      <h1> Bienvenido a tu Sistema de Gestión Escolar  <?php echo $_SESSION['nombre']; ?></h1>
    </header>
    <div>
          
            
        </div>

    <nav>
        <ul>
            <li><a href="../views/inicio.php">Inicio</a></li>
            <li><a href="../horariosup/crearhorarios.php">Crear Horario</a></li>
            <li><a href="horarios_guardados.php">Horarios Guardados</a></li>
            <li><a href="../materiasid/materias_tabla.php">Agregar Materias</a></li>
            <li><a href="../maestrosid/maestros_tabla.php">Agregar Maestros</a></li>
            <li><a href="../gruposid/grupos_tabla.php">Agregar Grupos</a></li>
            <li><a href="../salonesid/salones_tabla.php">Agregar Salones</a></li>
            <li><a href="../views/user.php">Administrar usuarios</a></li>
            <li><a href="../includes/_sesion/cerrarSesion.php">Cerrar Sesión<i class="fa fa-power-off" aria-hidden="true"></i></a> </li>
        </ul>
    </nav>

    <div class="container">
    <div class="carrera">
        <a href="gastro_horario.php">
            <img src="../images/gastro.png" alt="Carrera 1">
        </a>
    </div>
    <div class="carrera">
        <a href="../horariosup/mantenimiento_horario.php">
            <img src="../images/mantenimiento.png" alt="Carrera 2">
        </a>
    </div>
    <div class="carrera">
        <a href="tics_horario.php">
            <img src="../images/tics.png" alt="Carrera 3">
        </a>
    </div>
    <div class="carrera">
        <a href="../horariosup/negocios_horario.php">
            <img src="../images/desarrollo.png" alt="Carrera 4">
        </a>
    </div>
</div>



    <footer>
        <p>&copy; 2024 Sistema de Gestión Escolar Héctor Darío Maya Aguilar</p>
    </footer>
</body>
</html>