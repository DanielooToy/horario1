
<?php
session_start();
error_reporting(0);

$validar = $_SESSION['nombre'];

if ($validar == null || $validar == '') {
    header("Location: ../includes/login.php");
    die();
}

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "r_user");

// Verificar la conexión
if ($conexion === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}

// Consulta para obtener los grupos desde la base de datos
$salones_query = "SELECT id, salon FROM salones";

$salones_result = mysqli_query($conexion, $salones_query);

// Verificar si hay error en la consulta
if (!$salones_result) {
    die("Error al obtener los salones: " . mysqli_error($conexion));
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
        #grupos-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        #grupos-table th, #grupos-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #grupos-table th {
            background-color: #2f2c79;
            color: white;
        }

        #grupos-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #grupos-table tr:hover {
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
            color: #212529; /* Color amarillo */
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
            <li style="float: left;"><a href="../materiasid/materias_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Materias</a></li>
            <li style="float: left;"><a href="../maestrosid/maestros_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Maestros</a></li>
            <li style="float: left;"><a href="../gruposid/grupos_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Grupos</a></li>
            <li style="float: left;"><a href="salones_tabla.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Agregar Salones</a></li>
            <li style="float: left;"><a href="../views/user.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Administrar usuarios</a></li>
            <li style="float: left;"><a href="../includes/_sesion/cerrarSesion.php" style="display: block; color: white; text-align: center; padding: 14px 16px; text-decoration: none;">Cerrar Sesión<i class="fa fa-power-off" aria-hidden="true"></i></a> </li>
        </ul>
    </nav>

    <div class="search-container">
        <label for="search">Buscar Salón:</label>
        <input type="text" id="search" onkeyup="searchGrupos()" placeholder="Ingrese el nombre del salón">
    </div>

    <a href="agregar_salones.php" button id="btn-nuevo-usuario">Nuevo Salón</a>
    <br>
    <p></p>
    <br>

    <table border="1" id="grupos-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Salón</th>
                <th>Acciones</th>
                
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar los grupos obtenidos de la base de datos
            while ($row = mysqli_fetch_assoc($salones_result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['salon'] . "</td>";
              
                
                // Agregar botones de editar y eliminar
                echo "<td>";
                echo "<a class='btn btn-eliminar' href='eliminar_salones.php?id=" . $row['id'] . "'>Eliminar</a>";
              
                // Agregar el enlace de editar según tu estructura de URL
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
    function searchGrupos() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search");
        filter = input.value.toUpperCase();
        table = document.getElementById("grupos-table");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1]; // Cambiar el índice a 1 para la columna del nombre del salón
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
