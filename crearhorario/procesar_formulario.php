<?php
// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $tabla_id = $_POST["tabla_id"];
    $grado_id = $_POST["grado_id"];
    $grupo_id = $_POST["grupo_id"];
    $salon_id = $_POST["salon_id"];
    $turno_id = $_POST["turno_id"];
    $maestro_id = $_POST["maestro_id"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $materia_id = $_POST["materia_id"];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "r_user";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Insertar los datos en la tabla horario2
    $sql = "INSERT INTO horario2 (tabla_id, grado_id, grupo_id, salon_id, turno_id, maestro_id, hora_inicio, hora_fin, materia_id)
            VALUES ('$tabla_id', '$grado_id', '$grupo_id', '$salon_id', '$turno_id', '$maestro_id', '$hora_inicio', '$hora_fin', '$materia_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Datos insertados correctamente.";
    } else {
        echo "Error al insertar datos: " . $conn->error;
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si no se recibieron datos del formulario, redirigir al formulario
    header("Location: formulario.php");
    exit();
}
?>
