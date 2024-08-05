
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Estilos para la barra de búsqueda */
        #search-container {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        #search-container input[type=text] {
            padding: 10px;
            margin: 5px;
            width: 50%;
            box-sizing: border-box;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        #search-container input[type=text]:focus {
            outline: none;
            border-color: #2f2c79;
        }

        /* Estilos para la tabla */
        #usuarios-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        #usuarios-table th, #usuarios-table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #usuarios-table th {
            background-color: #2f2c79;
            color: white;
        }

        #usuarios-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #usuarios-table tr:hover {
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
            color: #212529;
        }

        .btn-eliminar {
            background-color: #dc3545; /* Color rojo */
            color: #fff;
        }

        .btn-agregar {
            background-color: #28a745; /* Color verde */
            color: #fff;
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

        /* Estilos para el encabezado y la navegación */
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

        /* Estilos para el botón Nuevo Usuario */
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
    <header>
        <h1>Bienvenido a tu Sistema de Gestión Escolar <?php echo $_SESSION['nombre']; ?></h1>
    </header>
    <nav>
    <ul>
            <li><a href="inicio.php">Inicio</a></li>
            <li><a href="../horariosup/crearhorarios.php">Crear Horario</a></li>
            <li><a href="../horariosup/horarios_guardados.php">Horarios Guardados</a></li>

            <li><a href="../materiasid/materias_tabla.php">Agregar Materias</a></li>
            <li><a href="../maestrosid/maestros_tabla.php">Agregar Maestros</a></li>
            <li><a href="../gruposid/grupos_tabla.php">Agregar Grupos</a></li>
            <li><a href="../salonesid/salones_tabla.php">Agregar Salones</a></li>
            <li><a href="../views/user.php">Administrar usuarios</a></li>
            <li><a href="../includes/_sesion/cerrarSesion.php">Cerrar Sesión<i class="fa fa-power-off" aria-hidden="true"></i></a> </li>
        </ul>
    </nav>
    <main>
      
        
        <div id="search-container">
        <label for="search">Buscar Usuario:</label>
            <input type="text" id="search-input" placeholder="Buscar por correo electrónico">
        </div>

        <a href="index2.php" button id="btn-nuevo-usuario">Nuevo Usuario</a>
        <br>
        <p></p>
        <br>

        <table id="usuarios-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Password</th>
                    <th>Teléfono</th>
                    <th>Fecha</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php
                    // Realizar la conexión a la base de datos
                    $conexion = mysqli_connect("localhost", "root", "", "r_user");

                    // Consulta SQL sin filtro
                    $SQL = "SELECT user.id, user.nombre, user.correo, user.password, user.telefono,
                            user.fecha, permisos.rol FROM user
                            LEFT JOIN permisos ON user.rol = permisos.id";
                    
                    // Ejecutar la consulta SQL
                    $dato = mysqli_query($conexion, $SQL);

                    if ($dato->num_rows > 0) {
                        while ($fila = mysqli_fetch_array($dato)) {
                ?>
                <tr>
                    <td><?php echo $fila['correo']; ?></td>
                    <td><?php echo $fila['nombre']; ?></td>
                    <td><?php echo $fila['password']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>
                    <td><?php echo $fila['rol']; ?></td>
                    <td>
                        <a class="btn btn-editar" href="editar_user.php?id=<?php echo $fila['id']?>">Editar</a>
                        <a class="btn btn-eliminar" href="eliminar_user.php?id=<?php echo $fila['id']?>">Eliminar</a>
                    </td>
                </tr>
                <?php
                        }
                    } else {
                ?>
                <tr>
                    <td colspan="7">No existen registros</td>
                </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
    </main>
    <footer>
        <p>&copy; 2024 Sistema de Gestión Escolar Héctor Darío Maya Aguilar</p>
    </footer>

    <script>
        // Función para realizar la búsqueda en tiempo real
        document.getElementById('search-input').addEventListener('input', function() {
            var searchValue = this.value.toLowerCase();
            var rows = document.getElementById('table-body').getElementsByTagName('tr');

            for (var i = 0; i < rows.length; i++) {
                var cells = rows[i].getElementsByTagName('td');
                var found = false;

                for (var j = 0; j < cells.length; j++) {
                    var cellValue = cells[j].textContent.toLowerCase();
                    if (cellValue.includes(searchValue)) {
                        found = true;
                        break;
                    }
                }

                rows[i].style.display = found ? '' : 'none';
            }
        });
    </script>
</body>
</html>
