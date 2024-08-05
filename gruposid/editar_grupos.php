<?php
session_start();
error_reporting(0);

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nombre'])) {
    header("Location: ../includes/login.php");
    exit; // Finalizar el script para evitar que se ejecute más código
}

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $id = $_POST['id'];
    $grado = $_POST['grado'];
    $grupo = $_POST['grupo'];
    $turno_texto = $_POST['turno'];
    
    // Realizar la conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "r_user");

    // Verificar la conexión
    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Verificar si el turno seleccionado existe en la tabla turnos
    $consulta_turno = "SELECT id FROM turnos WHERE turno = '$turno_texto'";
    $resultado_turno = mysqli_query($conexion, $consulta_turno);

    if (!$resultado_turno || mysqli_num_rows($resultado_turno) == 0) {
        echo "Error: El turno seleccionado no existe.";
        exit;
    }

    // Obtener el ID del turno
    $fila_turno = mysqli_fetch_assoc($resultado_turno);
    $turno_id = $fila_turno['id'];

    // Preparar la consulta SQL para actualizar el registro
    $consulta = "UPDATE grupos SET grado='$grado', grupo='$grupo', turno='$turno_id' WHERE id=$id";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $consulta)) {
        // Redireccionar a la tabla después de editar los datos
        header("Location: grupos_tabla.php");
        exit;
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}

// Obtener el ID del usuario a editar
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Verificar si se proporcionó un ID válido
if (!$id) {
    echo "ID no proporcionado";
    exit;
}

// Realizar la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "r_user");

// Verificar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Preparar la consulta SQL para obtener los datos del usuario
$consulta = "SELECT * FROM grupos WHERE id = $id";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $consulta);

// Verificar si se encontró el usuario
if ($resultado && mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del usuario
    $usuario = mysqli_fetch_assoc($resultado);
} else {
    echo "No se encontró el grupo";
}

// Cerrar la conexión
mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Grupo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        form {
            margin: 0 auto;
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="grado">Grado:</label>
    <input type="text" id="grado" name="grado" value="<?php echo $usuario['grado']; ?>"><br><br>

    <label for="grupo">Grupo:</label>
    <input type="text" id="grupo" name="grupo" value="<?php echo $usuario['grupo']; ?>"><br><br>

    <label for="turno">Turno:</label>
    <select id="turno" name="turno">
        <?php
        // Obtener los turnos de la tabla turnos
        $conexion = mysqli_connect("localhost", "root", "", "r_user");
        $consulta_turnos = "SELECT * FROM turnos";
        $result_turnos = mysqli_query($conexion, $consulta_turnos);

        if ($result_turnos && mysqli_num_rows($result_turnos) > 0) {
            while ($fila_turno = mysqli_fetch_assoc($result_turnos)) {
                $selected = ($usuario['turno'] == $fila_turno['id']) ? 'selected' : '';
                echo "<option value='{$fila_turno['turno']}' $selected>{$fila_turno['turno']}</option>";
            }
        }
        ?>
    </select><br><br>

    <input type="submit" value="Guardar cambios">
</form>

</body>
</html>
