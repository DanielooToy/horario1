<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario para Horario 2</title>
</head>
<body>
    <h2>Formulario para Horario 2</h2>
    <form action="procesar_formulario.php" method="POST">

    <label for="tabla_id">ID de la Tabla:</label>
        <input type="text" name="tabla_id" id="tabla_id" required><br><br>


        <label for="grado_id">Grado:</label>
        <select name="grado_id" id="grado_id" required>
            <option value="">Selecciona un grado</option>
            <?php
            // Conexión a la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "r_user";

            $conn = new mysqli($servername, $username, $password, $dbname);

            // Consulta SQL para obtener los grados
            $sql = "SELECT id, grado FROM grupos";
            $result = $conn->query($sql);

            // Mostrar opciones en el selector
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['grado'] . "</option>";
                }
            }
            ?>
        </select><br><br>
        
        <label for="grupo_id">Grupo:</label>
        <select name="grupo_id" id="grupo_id" required>
            <option value="">Selecciona un grupo</option>
            <?php
    // Consulta SQL para obtener los grupos
    $sql = "SELECT id, grupo FROM grupos";
    $result = $conn->query($sql);

    // Mostrar opciones en el selector
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['grupo'] . "</option>";
        }
    }
    ?>
        </select><br><br>
        
        <label for="salon_id">Salón:</label>
        <select name="salon_id" id="salon_id" required>
            <option value="">Selecciona un salón</option>
            <?php
    // Consulta SQL para obtener los grupos
    $sql = "SELECT id, salon FROM salones";
    $result = $conn->query($sql);

    // Mostrar opciones en el selector
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['salon'] . "</option>";
        }
    }
    ?>
        </select><br><br>
        
        <label for="turno_id">Turno:</label>
        <select name="turno_id" id="turno_id" required>
            <option value="">Selecciona un turno</option>
            <?php
    // Consulta SQL para obtener los grupos
    $sql = "SELECT id, turno FROM turnos";
    $result = $conn->query($sql);

    // Mostrar opciones en el selector
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['turno'] . "</option>";
        }
    }
    ?>
        </select><br><br>
        
        <label for="maestro_id">Maestro:</label>
        <select name="maestro_id" id="maestro_id" required>
            <option value="">Selecciona un maestro</option>
            <?php
    // Consulta SQL para obtener los grupos
    $sql = "SELECT id, nombre_completo FROM maestros";
    $result = $conn->query($sql);

    // Mostrar opciones en el selector
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre_completo'] . "</option>";
        }
    }
    ?>
        </select><br><br>
        
        <label for="hora_inicio">Hora de Inicio:</label>
        <input type="time" name="hora_inicio" id="hora_inicio" required><br><br>
        
        <label for="hora_fin">Hora de Fin:</label>
        <input type="time" name="hora_fin" id="hora_fin" required><br><br>
        
        <label for="materia_id">Materia:</label>
        <select name="materia_id" id="materia_id" required>
            <option value="">Selecciona una materia</option>
            <?php
    // Consulta SQL para obtener los grupos
    $sql = "SELECT id, nombre_materia FROM materias";
    $result = $conn->query($sql);

    // Mostrar opciones en el selector
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre_materia'] . "</option>";
        }
    }
    ?>
        </select><br><br>
        
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
