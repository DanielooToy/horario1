<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Horarios</title>
</head>
<body>
    <h2>Formulario de Horarios</h2>
    <form action="procesar_formulario.php" method="POST">
    
    <label for="tabla_id">ID de la Tabla:</label>
    <input type="text" name="tabla_id" id="tabla_id" required><br><br>

        <table id="horarios-table">
            <thead>
                <tr>
                    <th rowspan="2">Hora Inicio</th>
                    <th rowspan="2">Hora Fin</th>
                    <th colspan="5">Días de la Semana</th>
                </tr>
                <tr>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Generar filas de la tabla con selectores de días
                for ($i = 1; $i <= 8; $i++) { // Puedes ajustar el número de filas según tu horario
                    echo "<tr>";
                    // Columna para la hora de inicio
                    echo "<td><input type='time' name='hora_inicio[]' required></td>";
                    // Columna para la hora de fin
                    echo "<td><input type='time' name='hora_fin[]' required></td>";
                    // Columnas para los selectores de días
                    echo "<td><input type='checkbox' name='dias[$i][]' value='lunes'> Lunes</td>";
                    echo "<td><input type='checkbox' name='dias[$i][]' value='martes'> Martes</td>";
                    echo "<td><input type='checkbox' name='dias[$i][]' value='miercoles'> Miércoles</td>";
                    echo "<td><input type='checkbox' name='dias[$i][]' value='jueves'> Jueves</td>";
                    echo "<td><input type='checkbox' name='dias[$i][]' value='viernes'> Viernes</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
