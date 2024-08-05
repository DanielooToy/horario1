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
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Realizar la conexión a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "r_user");

    // Verificar la conexión
    if (!$conexion) {
        die("Error al conectar con la base de datos: " . mysqli_connect_error());
    }

    // Preparar la consulta SQL para actualizar el registro
    $consulta = "UPDATE user SET nombre='$nombre', correo='$correo', telefono='$telefono', password='$password', rol='$rol' WHERE id=$id";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $consulta)) {
        // Redireccionar a la tabla después de editar los datos
        header("Location: user.php");
        exit;
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}

// Obtener el ID del usuario a editar
$id = $_GET['id'];

// Realizar la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "r_user");

// Verificar la conexión
if (!$conexion) {
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

// Preparar la consulta SQL para obtener los datos del usuario
$consulta = "SELECT * FROM user WHERE id = $id";

// Ejecutar la consulta
$resultado = mysqli_query($conexion, $consulta);

// Verificar si se encontró el usuario
if (mysqli_num_rows($resultado) > 0) {
    // Obtener los datos del usuario
    $usuario = mysqli_fetch_assoc($resultado);
} else {
    echo "No se encontró el usuario";
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

<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <label for="nombre">Correo:</label>
    <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>"><br><br>
    <label for="correo">Nombre:</label>
    <input type="text" id="correo" name="correo" value="<?php echo $usuario['correo']; ?>"><br><br>
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" value="<?php echo $usuario['telefono']; ?>"><br><br>
    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" value="<?php echo $usuario['password']; ?>"><br><br>
    <label for="rol">Rol:</label>
    <select id="rol" name="rol">
        <option value="1" <?php if ($usuario['rol'] == 1) echo 'selected'; ?>>Administrador</option>
        <option value="2" <?php if ($usuario['rol'] == 2) echo 'selected'; ?>>Lector</option>
    </select><br><br>
    <input type="submit" value="Guardar cambios">
</form>

</body>
</html>