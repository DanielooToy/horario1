<?php
// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=r_user', 'root', '');

// Recuperar todos los usuarios y horarios para mostrar en el formulario
$stmt = $pdo->prepare("SELECT id, nombre FROM usuarios");
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("SELECT id, nombre_materia FROM horarios");
$stmt->execute();
$horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si los campos necesarios están presentes
    if (isset($_POST['user_id'], $_POST['horario_id'])) {
        // Obtén los valores del formulario
        $user_id = $_POST['user_id'];
        $horario_id = $_POST['horario_id'];

        // Prepara la consulta SQL
        $sql = "INSERT INTO user_horarios (user_id, horario_id) VALUES (?, ?)";

        // Inserta los datos en la base de datos
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $horario_id]);

        // Redirige al usuario a la misma página con un mensaje de éxito
        header("Location: asignar_horarios.php?success=" . urlencode("Horario asignado con éxito."));
        exit;
    }
}
?>