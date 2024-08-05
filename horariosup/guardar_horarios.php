<?php
// Conectar a la base de datos
$db = new PDO('mysql:host=localhost;dbname=r_user', 'root', '');

// Obtén el tabla_id del formulario
$tabla_id = $_POST['tabla_id'];

// Obtén los valores seleccionados para cada día de la semana
$dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
foreach ($dias as $dia) {
    ${$dia} = $_POST[$dia];
}

// Recuperar la fila de la columna tabla_id que coincide con el tabla_id del formulario
$stmt = $db->prepare("SELECT * FROM horarios WHERE tabla_id = :tabla_id");
$stmt->bindParam(':tabla_id', $tabla_id);
$stmt->execute();
$horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepara la consulta SQL para actualizar la base de datos
$stmt = $db->prepare("UPDATE horarios SET lunes = :lunes, martes = :martes, miercoles = :miercoles, jueves = :jueves, viernes = :viernes WHERE id = :id");

// Vincula los valores a la consulta SQL y ejecuta la consulta para cada fila
foreach ($horarios as $index => $horario) {
    $stmt->bindParam(':id', $horario['id']);
    foreach ($dias as $dia) {
        $stmt->bindParam(":$dia", ${$dia}[$index]);
    }
    $stmt->execute();
}

// Redirige al usuario de vuelta a la página de edición
header('Location: editar_horario.php?tabla_id=' . $tabla_id . '&success=1');
exit;
?>