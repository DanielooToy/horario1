<?php
session_start();
error_reporting(0);

// Verificar si el usuario está autenticado
if (!isset($_SESSION['nombre'])) {
    header("Location: ../includes/login.php");
    exit; // Finalizar el script para evitar que se ejecute más código
}
// Obtener el ID del usuario a editar
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Realizar la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "r_user");

// Verificar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Preparar la consulta SQL para obtener los datos del usuario
$usuario_query = "SELECT * FROM maestros WHERE id=$id";

// Ejecutar la consulta
$usuario_result = mysqli_query($conexion, $usuario_query);

// Verificar si hay error en la consulta
if (!$usuario_result) {
    die("Error al obtener los datos del usuario: " . mysqli_error($conexion));
}

// Obtener los datos del usuario
$usuario = mysqli_fetch_assoc($usuario_result);

// Preparar la consulta SQL para obtener las carreras
$carreras_query = "SELECT * FROM carreras";

// Ejecutar la consulta
$carreras_result = mysqli_query($conexion, $carreras_query);

// Verificar si hay error en la consulta
if (!$carreras_result) {
    die("Error al obtener las carreras: " . mysqli_error($conexion));
}

// Verificar si se envió el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $nombre_completo = $_POST['nombre_completo'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $carrera = $_POST['carrera'];

    // Preparar la consulta SQL para actualizar los datos del usuario
    $update_query = "UPDATE maestros SET nombre_completo='$nombre_completo', fecha_nacimiento='$fecha_nacimiento', email='$email', telefono='$telefono', direccion='$direccion', carrera='$carrera' WHERE id=$id";

    // Ejecutar la consulta
    $update_result = mysqli_query($conexion, $update_query);

    // Verificar si hay error en la consulta
    if (!$update_result) {
        die("Error al actualizar los datos del usuario: " . mysqli_error($conexion));
    }

    // After handling the form submission, redirect the user
    header("Location: maestros_tabla.php");
    exit;
}

// Cerrar la conexión
mysqli_close($conexion);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
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


<form method="POST" action="editar_maestros.php?id=<?php echo $id; ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="nombre_completo">Nombre Completo:</label>
    <input type="text" id="nombre" name="nombre_completo" value="<?php echo $usuario['nombre_completo']; ?>"><br><br>

    <label for="fecha_nacimiento">Fecha de Nacimineto:</label>
    <input type="date" id="nombre" name="fecha_nacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>"><br><br>

    <label for="email">Correo:</label>
    <input type="text" id="nombre" name="email" value="<?php echo $usuario['email']; ?>"><br><br>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="nombre" name="telefono" value="<?php echo $usuario['telefono']; ?>"><br><br>

    <label for="direccion">Dirección:</label>
    <input type="text" id="nombre" name="direccion" value="<?php echo $usuario['direccion']; ?>"><br><br>

    <select name="carrera">
<?php while ($carrera = mysqli_fetch_assoc($carreras_result)): ?>
    <option value="<?php echo $carrera['id']; ?>" <?php if ($carrera['id'] == $usuario['carrera']) echo 'selected'; ?>><?php echo $carrera['nombre_carrera']; ?></option>
<?php endwhile; ?>
</select>


    <input type="submit" value="Guardar cambios">
</form>

</body>
</html>