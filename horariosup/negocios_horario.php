<?php
// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=r_user', 'root', '');

// Recuperar las materias de la carrera de gastronomía
$stmt = $pdo->prepare("SELECT materias.id, materias.nombre_materia 
                       FROM materias 
                       JOIN carreras ON materias.nombre_carrera = carreras.id 
                       WHERE carreras.id = 8");
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica si los campos necesarios están presentes
    if (isset($_POST['tabla_id'], $_POST['hora_inicio'], $_POST['hora_fin'], $_POST['lunes'], $_POST['martes'], $_POST['miercoles'], $_POST['jueves'], $_POST['viernes'])) {
        // Obtén los valores del formulario
        $tabla_id = $_POST['tabla_id'];
        $horas_inicio = $_POST['hora_inicio'];
        $horas_fin = $_POST['hora_fin'];
        $lunes = $_POST['lunes'];
        $martes = $_POST['martes'];
        $miercoles = $_POST['miercoles'];
        $jueves = $_POST['jueves'];
        $viernes = $_POST['viernes'];
    
        // Prepara la consulta SQL
        $sql = "INSERT INTO horarios (tabla_id, hora_inicio, hora_fin, lunes, martes, miercoles, jueves, viernes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
        // Inserta los datos en la base de datos
        $stmt = $pdo->prepare($sql);
        $success = false;
        for ($i = 0; $i < count($horas_inicio); $i++) {
            // Verifica si ya existe una materia con el mismo nombre y la misma hora de inicio
            $stmt_check = $pdo->prepare("SELECT * FROM horarios WHERE hora_inicio = ? AND (lunes = ? OR martes = ? OR miercoles = ? OR jueves = ? OR viernes = ?)");
            $stmt_check->execute([$horas_inicio[$i], $lunes[$i], $martes[$i], $miercoles[$i], $jueves[$i], $viernes[$i]]);
            if ($stmt_check->fetch()) {
                // Si la consulta devuelve un resultado, redirige al usuario de vuelta a la página del formulario con un mensaje de error
                header("Location: negocios_horario.php?error=" . urlencode("Error: Ya existe una materia con el mismo nombre y la misma hora de inicio."));
                exit;
            }

            $params = [$tabla_id, $horas_inicio[$i], $horas_fin[$i], $lunes[$i], $martes[$i], $miercoles[$i], $jueves[$i], $viernes[$i]];
            if($stmt->execute($params)) {
                $success = true;
            }
        }

        if($success) {
            // Redirige después de la inserción exitosa
            header("Location: negocios_horario.php?success=true");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Horarios</title>
 <!-- Incluye Bootstrap -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
      
       
     body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        .container {
    width: 100%;
    margin: auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            float: right;
        }
        .form-group button:hover {
            background-color: #0056b3;
        }
        .table-responsive {
    overflow-x: auto;
}
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ff6d66;
        }
        </style>
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        Los datos se han guardado correctamente.
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php echo urldecode($_GET['error']); ?>
    </div>
<?php endif; ?>
<div class="container">
    <h1 class="my-4">Horario</h1>
    <img src="../images/desarrollo.png" style="width:200px; float:right; margin-right: 100px">
    <form method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="tabla_id">Tabla ID:</label>
                <input type="text" class="form-control" id="tabla_id" name="tabla_id" required>
            </div>
           
        
        </div>
        <div class="table-responsive">
        <table id="horario">
            <tr>
                <th>Hora de inicio</th>
                <th>Hora de fin</th>
                <th>Lunes</th>
                <th>Martes</th>
                <th>Miércoles</th>
                <th>Jueves</th>
                <th>Viernes</th>
            </tr>
            <!-- Las filas se agregarán aquí -->
        </table>
        </div>
        <button type="button" id="agregar">Agregar fila</button>
        <button type="button" id="eliminar">Eliminar fila</button>
        <input type="submit" value="Guardar">
<a href="../horariosup/crearhorarios.php"><button type="button">Cancelar</button></a>
<script>
document.getElementById('cancelar').addEventListener('click', function() {
    window.location.href = '../horariosup/crearhorario.php';
});
</script>
    </form>

    <script>
        const materias = <?php echo json_encode($materias); ?>;
        const tabla = document.getElementById('horario');
        const agregar = document.getElementById('agregar');
        const eliminar = document.getElementById('eliminar');
        agregar.addEventListener('click', () => {
    const fila = document.createElement('tr');

    const celdaInicio = document.createElement('td');
    celdaInicio.className = 'hora-columna';
    const celdaFin = document.createElement('td');
    celdaFin.className = 'hora-columna';
    const inputInicio = document.createElement('input');
    const inputFin = document.createElement('input');
    inputInicio.type = 'time';
inputInicio.name = 'hora_inicio[]'; // Agrega un atributo name
inputFin.type = 'time';
inputFin.name = 'hora_fin[]'; // Agrega un atributo name
    celdaInicio.appendChild(inputInicio);
    celdaFin.appendChild(inputFin);
    fila.appendChild(celdaInicio);
    fila.appendChild(celdaFin);

    ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'].forEach(dia => {
        const celda = document.createElement('td');
        const select = document.createElement('select');
        select.className = 'materia-select';
        select.name = dia + '[]'; // Agrega un atributo name
        const materiaPrint = document.createElement('span');
        materiaPrint.className = 'materia-print';
        celda.appendChild(materiaPrint);
        materias.forEach(materia => {
            const option = document.createElement('option');
            option.value = materia.id;
            option.textContent = materia.nombre_materia;
            select.appendChild(option);
        });
        celda.appendChild(select);
        fila.appendChild(celda);
    });

    tabla.appendChild(fila);
});
        eliminar.addEventListener('click', () => {
            const filas = tabla.getElementsByTagName('tr');
            if (filas.length > 2) { // No eliminar la fila de encabezado
                tabla.removeChild(filas[filas.length - 1]);
            }
        });
     
       
    </script>
</body>
</html>