<?php
session_start();
error_reporting(0);

// Verificar la sesión
$validar = $_SESSION['nombre'];
if ($validar == null || $validar == '') {
    header("Location: ./includes/login.php");
    die();
}

// Conexión a la base de datos
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

// Procesamiento del formulario para agregar materias
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si el formulario se envió correctamente
    if(isset($_POST['registrar'])) {
        // Recuperar los datos del formulario
        $nombre_materia = $_POST['nombre_materia'];
        $nombre_carrera = $_POST['carrera'];

        // Insertar los datos en la base de datos
        $insert_query = "INSERT INTO materias (nombre_materia, nombre_carrera) VALUES ('$nombre_materia', '$nombre_carrera')";

        if (mysqli_query($conexion, $insert_query)) {
            echo "La materia se ha agregado correctamente.";
        } else {
            echo "Error al agregar la materia: " . mysqli_error($conexion);
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
    <title>Agregar Materia</title>
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
    </style>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <br>
                        <br>
                        <h3 class="text-center">Agregar Materia</h3>
                        <div class="form-group">
                            <label for="nombre_materia" class="form-label">Nombre de la Materia *</label>
                            <input type="text" id="nombre_materia" name="nombre_materia" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="carrera" class="form-label">Carrera *</label>
                            <select class="form-select" id="carrera" name="carrera" required>
                                <?php
                                // Mostrar las opciones de carrera obtenidas de la base de datos
                                while ($row = mysqli_fetch_assoc($carreras_result)) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['nombre_carrera'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <br>
                        <div class="mb-3">
                            <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                            <a href="materias_tabla.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
