<?php
// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $tabla_id = $_POST["tabla_id"];
    $hora_inicio = $_POST["hora_inicio"];
    $hora_fin = $_POST["hora_fin"];
    $dias = $_POST["dias"];

    // Aquí puedes procesar los datos como desees, como insertarlos en la base de datos

    // Por ejemplo, puedes recorrer los datos y guardarlos en la base de datos
    foreach ($hora_inicio as $key => $value) {
        // Verificar si se seleccionó al menos un día para esta fila
        if (!empty($dias[$key])) {
            // Construir una cadena con los días seleccionados separados por coma
            $dias_seleccionados = implode(",", $dias[$key]);
            // Aquí puedes insertar los datos en la base de datos
            // Por ejemplo:
            // $sql = "INSERT INTO horario (tabla_id, hora_inicio, hora_fin, dias_semana)
            //         VALUES ('$tabla_id', '$hora_inicio[$key]', '$hora_fin[$key]', '$dias_seleccionados')";
            // Luego ejecutas la consulta SQL...
        }
    }

    // Si todo se procesa correctamente, puedes redirigir a otra página
    header("Location: pagina_exito.php");
    exit();
} else {
    // Si no se recibieron datos del formulario, redirigir al formulario
    header("Location: formulario.php");
    exit();
}
?>
