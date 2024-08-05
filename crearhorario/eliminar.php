<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "r_user";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verificar si tabla_id está establecido y no está vacío
if (isset($_POST['tabla_id']) && !empty($_POST['tabla_id'])) {
    $tabla_id = $_POST['tabla_id'];

    // Preparar la consulta SQL
    $stmt = $conn->prepare("DELETE FROM horarios WHERE tabla_id = ?");

    // Vincular el tabla_id a la consulta SQL
    $stmt->bind_param("s", $tabla_id);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        http_response_code(200); // Enviar un código de estado 200 (OK) si la eliminación fue exitosa
    } else {
        http_response_code(500); // Enviar un código de estado 500 (Error interno del servidor) si hubo un problema
    }

    $stmt->close();
} else {
    http_response_code(400); // Enviar un código de estado 400 (Solicitud incorrecta) si tabla_id no está establecido o está vacío
}

$conn->close();
?>