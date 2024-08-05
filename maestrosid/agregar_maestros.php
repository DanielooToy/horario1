<?php
session_start();
error_reporting(0);

$conexion = mysqli_connect("localhost", "root", "", "r_user");

// Verificar la conexión
if ($conexion === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}

// Consulta para obtener las carreras desde la base de datos
$carreras_query = "SELECT id, nombre_carrera FROM carreras";
$carreras_result = mysqli_query($conexion, $carreras_query);

// Verificar si hay error en la consulta
if (!$carreras_result) {
    die("Error al obtener las carreras: " . mysqli_error($conexion));
}

// Procesamiento del formulario para agregar maestros
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el formulario se envió correctamente
    if(isset($_POST['registrar'])) {
        // Recuperar los datos del formulario
        $nombre_completo = $_POST['nombre_completo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $carrera = $_POST['carrera']; // Tomar el ID de carrera seleccionado

        // Insertar los datos en la base de datos
        $insert_query = "INSERT INTO maestros (nombre_completo, fecha_nacimiento, email, telefono, direccion, carrera) VALUES ('$nombre_completo', '$fecha_nacimiento', '$email', '$telefono', '$direccion', '$carrera')";

        if (mysqli_query($conexion, $insert_query)) {
            echo "Maestro se ha agregado correctamente.";
        } else {
            echo "Error al agregar maestro: " . mysqli_error($conexion);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Maestro</title>
    <!-- Agrega tus estilos CSS aquí -->
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
        a.button {
    display: inline-block;
    padding: 10px 20px;
    margin: 10px 0;
    color: #fff;
    background-color: #f44336;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

a.button:hover {
    background-color: #d32f2f;
}
    </style>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label for="nombre_completo">Nombre Completo</label>
    <input type="text" id="nombre_completo" name="nombre_completo" required>

    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required>

    <label for="email">Email</label>
    <input type="email" id="email" name="email" required>

    <label for="telefono">Teléfono</label>
    <input type="text" id="telefono" name="telefono" required>

    <label for="direccion">Dirección</label>
    <input type="text" id="direccion" name="direccion" required>

    <select name="carrera">
    <?php while ($carrera = mysqli_fetch_assoc($carreras_result)): ?>
        <option value="<?php echo $carrera['id']; ?>"><?php echo $carrera['nombre_carrera']; ?></option>
    <?php endwhile; ?>
</select>
    </ul>
    <input type="submit" name="registrar" value="Registrar">
<a href="maestros_tabla.php" class="button">Cancelar</a>
</form>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>