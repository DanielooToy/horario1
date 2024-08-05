<?php
// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=r_user', 'root', '');

// Recuperar todos los usuarios y sus horarios asignados
$stmt = $pdo->prepare("
    SELECT user.nombre, horarios.tabla_id
    FROM user
    INNER JOIN user_horarios ON user.id = user_horarios.user_id
    INNER JOIN horarios ON horarios.id = user_horarios.horario_id
");
$stmt->execute();
$usuariosHorarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Horarios Asignados</title>
</head>
<body>
    <h1>Horarios Asignados</h1>
    <table>
        <tr>
            <th>Usuario</th>
            <th>Horario</th>
        </tr>
        <?php foreach ($usuariosHorarios as $usuarioHorario): ?>
            <tr>
                <td><?= $usuarioHorario['nombre'] ?></td>
                <td><?= $usuarioHorario['tabla_id'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>