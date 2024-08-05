<?php
// Establecer la conexión con la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "r_user";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los horarios guardados
$sql_horarios = "SELECT * FROM horarios";
$result_horarios = $conn->query($sql_horarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Horarios Guardados</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        .materia {
            max-width: 150px; /* Ajustar el ancho máximo según sea necesario */
            word-wrap: break-word; /* Permitir que el texto se ajuste automáticamente */
            white-space: normal; /* Permitir que el texto se desborde y se divida en múltiples líneas */
        }
    </style>
</head>
<body>

<h2>Horarios Guardados</h2>

<?php
// Verificar si hay horarios guardados
if ($result_horarios->num_rows > 0) {
    // Inicializar variables para mantener el control de la hora actual
    $current_time = '';
    $first_iteration = true;

    // Mostrar cada horario guardado en la tabla
    while ($row = $result_horarios->fetch_assoc()) {
        // Verificar si la hora actual ha cambiado
        if ($current_time != $row['hora_inicio']) {
            // Si no es la primera iteración, cerrar la tabla anterior
            if (!$first_iteration) {
                echo "</table><br>";
            } else {
                $first_iteration = false;
            }
            // Mostrar la nueva hora inicio
            echo "<h3>Hora inicio: " . $row['hora_inicio'] . " - Hora fin: " . $row['hora_fin'] . "</h3>";
            // Inicializar la tabla para esta nueva hora
            echo "<table>";
            echo "<tr><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
            // Actualizar la hora actual
            $current_time = $row['hora_inicio'];
        }

        // Mostrar los datos del horario actual
        echo "<tr>";
        echo "<td>" . obtenerMateria($conn, $row["lunes"]) . "</td>";
        echo "<td>" . obtenerMateria($conn, $row["martes"]) . "</td>";
        echo "<td>" . obtenerMateria($conn, $row["miercoles"]) . "</td>";
        echo "<td>" . obtenerMateria($conn, $row["jueves"]) . "</td>";
        echo "<td>" . obtenerMateria($conn, $row["viernes"]) . "</td>";
        echo "</tr>";
    }
    // Cerrar la última tabla
    echo "</table>";
} else {
    echo "<p>No hay horarios guardados.</p>";
}
?>

</body>
</html>

<?php
// Función para obtener el nombre de la materia por su ID
function obtenerMateria($conn, $materia_id) {
    $sql = "SELECT nombre_materia FROM materias WHERE id = $materia_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["nombre_materia"];
    } else {
        return "Materia no encontrada";
    }
}
?>
