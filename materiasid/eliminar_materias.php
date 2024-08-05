<?php
require_once ("../includes/_db.php");

// Abrir la conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "r_user");

// Verificar la conexión
if ($conexion === false) {
    die("ERROR: No se pudo conectar. " . mysqli_connect_error());
}

if (isset($_POST['accion'])) { 
    switch ($_POST['accion']) {
        case 'editar_registro':
            editar_registro($conexion);
            break; 

        case 'eliminar_registro':
            eliminar_registro($conexion);
            break;

        case 'acceso_user':
            acceso_user($conexion);
            break;
    }
}

function eliminar_registro($conexion) {
    // extract($_POST); // No es necesario en este caso
    $id = $_POST['id'];
    $consulta = "DELETE FROM materias WHERE id= $id";

    mysqli_query($conexion, $consulta);
    header('Location: materias_tabla.php');
    exit(); // Asegurarse de salir del script después de la redirección
}

// Consulta para obtener las materias desde la base de datos
$materias_query = "SELECT id, nombre_materia, nombre_carrera FROM materias";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Materias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6 offset-sm-3">
                <div class="alert alert-danger text-center">
                    <p>¿Desea confirmar la eliminación del registro?</p>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <input type="hidden" name="accion" value="eliminar_registro">
                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                            <input type="submit" value="Eliminar" class="btn btn-danger">
                            <a href="materias_tabla.php" class="btn btn-success">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>