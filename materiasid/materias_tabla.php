<?php
session_start();
error_reporting(0);

$validar = $_SESSION['nombre'];

if ($validar == null || $validar = '') {
    header("Location: ../includes/login.php");
    die();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "r_user");

// Verificar la conexión
if ($conexion === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}

// Consulta para obtener las materias desde la base de datos
$materias_query = "SELECT m.id, m.nombre_materia, c.nombre_carrera 
                    FROM materias m 
                    INNER JOIN carreras c ON m.nombre_carrera = c.id";
$materias_result = mysqli_query($conexion, $materias_query);

// Verificar si hay error en la consulta
if (!$materias_result) {
    die("Error al obtener las materias: " . mysqli_error($conexion));
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
        /* Estilos para la barra de búsqueda */
        .search-container {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        .search-container input[type=text] {
            padding: 10px;
            margin: 5px;
            width: 50%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .search-container input[type=text]:focus {
            outline: none;
            border-color: #2f2c79;
        }
        /* Estilos para la tabla */
        #materias-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        #materias-table th, #materias-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #materias-table th {
            background-color: #2f2c79;
            color: white;
        }

        #materias-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #materias-table tr:hover {
            background-color: #ddd;
        }

        /* Estilos para los botones de acción */
        .btn {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-decoration: none;
            text-transform: uppercase;
            font-weight: bold;
        }

        .btn-editar {
            background-color: #ffc107; /* Color amarillo */
        }

        .btn-eliminar {
            background-color: #dc3545; /* Color rojo */
            color: #fff;
        }

        .btn-agregar {
            background-color: #28a745; /* Color verde */
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

        #btn-nuevo-usuario {
            background-color: #28a745; /* Color verde */
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-bottom: 20px;
            text-transform: uppercase;
            font-weight: bold;
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

            <li style="float: left;"><a href="materias_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Materias</a></li>
            <li style="float: left;"><a href="../maestrosid/maestros_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Maestros</a></li>
            <li style="float: left;"><a href="../gruposid/grupos_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Grupos</a></li>
            <li style="float: left;"><a href="../salonesid/salones_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Salones</a></li>
            <li style="float: left;"><a href="../views/user.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Administrar usuarios</a></li>
            <li style="float: left;"><a href="../includes/_sesion/cerrarSesion.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Cerrar Sesión<i class="fa fa-power-off" aria-hidden="true"></i></a> </li>
        </ul>
    </nav>

    <div class="search-container">
        <label for="search">Buscar Materia:</label>
        <input type="text" id="search" onkeyup="searchMaterias()" placeholder="Ingrese el nombre de la materia">
    </div>

    <a href="agregar_materias.php" button id="btn-nuevo-usuario">Nueva Materia </a>
    <br>
    <p></p>
    <br>


    <table border="1" id="materias-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre de la Materia</th>
                <th>Carrera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Consulta para obtener las materias desde la base de datos
            $materias_query = "SELECT materias.id, materias.nombre_materia, carreras.nombre_carrera 
                               FROM materias 
                               INNER JOIN carreras ON materias.nombre_carrera = carreras.id";
            $materias_result = mysqli_query($conexion, $materias_query);

            // Verificar si hay error en la consulta
            if (!$materias_result) {
                die("Error al obtener las materias: " . mysqli_error($conexion));
            }

            // Mostrar las materias obtenidas de la base de datos
            while ($row = mysqli_fetch_assoc($materias_result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['nombre_materia'] . "</td>";
                echo "<td>" . $row['nombre_carrera'] . "</td>";
                // Agregar botones de editar y eliminar
                echo "<td>";
                echo "<a class='btn btn-eliminar' href='eliminar_materias.php?id=" . $row['id'] . "'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function searchMaterias() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("materias-table");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Cambia 1 por la columna donde se encuentra el nombre de la materia
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
    <footer>
        <p>&copy; 2024 Sistema de Gestión Escolar Héctor Darío Maya Aguilar</p>
    </footer>
</body>
</html>
