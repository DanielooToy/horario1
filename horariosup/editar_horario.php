<?php
// Conectar a la base de datos
// Conectar a la base de datos
$db = new PDO('mysql:host=localhost;dbname=r_user', 'root', '');

// Obtén el tabla de la URL
$tabla_id = $_GET['tabla_id'];

// Comprobar si el parámetro success está presente
$successMessage = '';
if (isset($_GET['success'])) {
    $successMessage = "<div class='alert alert-success'>El horario ha sido editado con éxito.</div>";
}

// Recuperar la fila de la columna tabla_id que coincide con el tabla_id de la URL
$stmt = $db->prepare("SELECT * FROM horarios WHERE tabla_id = :tabla_id");
$stmt->bindParam(':tabla_id', $tabla_id);
$stmt->execute();
$horarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Recuperar todas las materias
$stmt = $db->prepare("SELECT * FROM materias");
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .search-container {
            margin-bottom: 20px;
        }
     

        .alert {
    padding: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
}

.alert-success {
    color: #3c763d;
    background-color: #dff0d8;
    border-color: #d6e9c6;
}
.cancel-button {
        display: inline-block;
        margin-top: 150px;
        padding: 10px 20px;
        background-color: #ff3229; /* blue */
        color: white;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
    }
    .guardar-button {
        display: inline-block;
        margin-top: 150px;
        padding: 10px 20px;
        background-color:  #4CAF50;/* blue */
        color: white;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
    }
    </style>
</head>
<body>
    <div class="container">
        <?php echo $successMessage; ?>
        <?php
        // Mostrar la tabla y los selectores
        if ($horarios) {
            echo "<h2>Tabla ID: " . $tabla_id . "</h2>";
            echo '<a href="horarios_guardados.php" class="cancel-button">Cancelar</a>';

            echo "<form action='guardar_horarios.php' method='post'>";
            echo "<input type='hidden' name='tabla_id' value='$tabla_id'>";
            echo "<table>";
            echo "<tr><th>Hora Inicio</th><th>Hora Fin</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
            foreach ($horarios as $index => $horario) {
                echo "<tr>";
                echo "<td>" . $horario['hora_inicio'] . "</td>";
                echo "<td>" . $horario['hora_fin'] . "</td>";
                $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'];
                foreach ($dias as $dia) {
                    echo "<td>";
                    echo "<select id='$dia' name='{$dia}[]'>";
                    foreach ($materias as $materia) {
                        $selected = $materia['id'] == $horario[$dia] ? "selected" : "";
                        echo "<option value='" . $materia['id'] . "' $selected>" . $materia['nombre_materia'] . "</option>";
                    }
                    echo "</select>";
                    echo "</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        
            echo "<input type='submit' value='Guardar' class='guardar-button'>";

            echo "</form>";
        }
      
        ?>
        <br>
     
    </div>
</body>
</html>