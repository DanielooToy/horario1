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

// Obtén el tabla_id del parámetro GET
$tabla_id = $_GET['tabla_id'];

// Consulta a la base de datos para obtener las filas de la tabla horarios que coincidan con el tabla_id

$stmt = $conn->prepare("
    SELECT horarios.tabla_id, horarios.hora_inicio, horarios.hora_fin, 
           lunes.nombre_materia as nombre_lunes, 
           martes.nombre_materia as nombre_martes, 
           miercoles.nombre_materia as nombre_miercoles, 
           jueves.nombre_materia as nombre_jueves, 
           viernes.nombre_materia as nombre_viernes 
    FROM horarios 
    LEFT JOIN materias as lunes ON horarios.lunes = lunes.id
    LEFT JOIN materias as martes ON horarios.martes = martes.id
    LEFT JOIN materias as miercoles ON horarios.miercoles = miercoles.id
    LEFT JOIN materias as jueves ON horarios.jueves = jueves.id
    LEFT JOIN materias as viernes ON horarios.viernes = viernes.id
    WHERE horarios.tabla_id = ? 
    ORDER BY horarios.tabla_id
");
if ($stmt) {
    $stmt->bind_param("s", $tabla_id);
    $stmt->execute();
    $result = $stmt->get_result();
?>
   
 
   <!DOCTYPE html>
<html lang="es">
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>

    <style>
       
       @media print {
          
        th:nth-child(1), td:nth-child(1) {
        display: none;
    }
    .update-button, #printButton, #cancelButton {
        display: none;
    }

            .no-print, #printButton {
        display: none;
    }

    #carreraSelect {
        display: none;
    }

    th {
    
        color: brown !important; /* Cambia este valor al color que prefieras para el texto */
    }


        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: -50px;
            flex-direction: column;
        }

        table {
            width: 80%;
            border-collapse: collapse;
        }

        th, td {
            border: 2px solid #888;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #d9d9d9;
            color: black;
        }

        .selector-group {
            display: block;
            text-align: center;
            margin-bottom: 20px;
        }

        .selector-group select {
            margin: 0 10px;
            
}
        

        .selected-value {
            font-size: 1.23em;
            text-align: center;
            margin-bottom: 1px;
        }
        .image-container {
    position: absolute;
    top: 0;
    text-align: center; /* Centrar contenido horizontalmente */
}

/* Estilo para las imágenes */
.image-container img {
    height: 70px;
    width: auto;
    margin: 0 20px; /* Espacio entre las imágenes */
}

#guerrero {
    height: 55px;
    width: auto;
}
         h4 {
            text-align: center;
            margin-top: -70px;
            font-family: "Constantia", serif; /* Ajustamos el margen superior del título */
        }
        h2 {
            text-align: center;
            margin-top: -1px;
            font-family: "Constantia", serif;  /* Ajustamos el margen superior del título */
        }
    </style>
</head>
<body>
   
<div class="image-container">
    <img src="../images/logouta.png">
    <img src="../images/eduguerrero.png" id="guerrero">
    <img src="../images/gastro.png" id="carrera">
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<h2>UNIVERSIDAD TECNOLÓGICA DE ACAPULCO</h2>
<h4><small>Organismo Público Descentralizado del Gobierno del Estado</small></h4>
<p> </p>
<select id="carreraSelect">
    <option value="gastro.png">Gastronomía</option>
    <option value="desarrollo.png">Desarrollo e Innovación Empresarial</option>
    <option value="mantenimiento.png">Mantenimiento Industrial</option>
    <option value="tics.png">Tecnologías de la Información</option>
</select>


<div class="selected-value"></div>

<div class="selector-group">
<label for="turno"><span class="selector-label">Carrera:</span></label>
    <select id="carrera" name="carrera" required>
        <option value="">Seleccionar carrera</option>
        <?php
        // Generar opciones para el campo desplegable de turnos
        $sql_turnos = "SELECT id, nombre_carrera FROM carreras";
        $result_turnos = $conn->query($sql_turnos);
        if ($result_turnos->num_rows > 0) {
            while ($row = $result_turnos->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["nombre_carrera"] . "</option>";
            }
        }
        ?>
    </select>

    <label for="turno"><span class="selector-label">Grado:</span></label>
    <select id="grado" name="grado" required>
    <?php
    // Generar opciones para el campo desplegable de grados
    $sql_grados = "SELECT id, grado FROM grupos";
    $result_grados = $conn->query($sql_grados);
    if ($result_grados->num_rows > 0) {
        while ($row = $result_grados->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["grado"] . "</option>";
        }
    }
    ?>
    </select>

    <label for="turno"><span class="selector-label">Grado:</span></label>
    <select id="grupo" name="grupo" required>
    <?php
        // Generar opciones para el campo desplegable de grupos
        $sql_grupos = "SELECT id, grupo FROM grupos";
        $result_grupos = $conn->query($sql_grupos);
        if ($result_grupos->num_rows > 0) {
            while ($row = $result_grupos->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["grupo"] . "</option>";
            }
        }
        ?>
    </select>

    <label for="turno"><span class="selector-label">Salón:</span></label>
    <select id="salon" name="salon" required>
    <?php
        // Generar opciones para el campo desplegable de salones
        $sql_salones = "SELECT id, salon FROM salones";
        $result_salones = $conn->query($sql_salones);
        if ($result_salones->num_rows > 0) {
            while ($row = $result_salones->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["salon"] . "</option>";
            }
        }
        ?>
    </select>

    <label for="turno"><span class="selector-label">Turno:</span></label>
    <select id="turno" name="turno" required>
    <?php
        // Generar opciones para el campo desplegable de turnos
        $sql_turnos = "SELECT id, turno FROM turnos";
        $result_turnos = $conn->query($sql_turnos);
        if ($result_turnos->num_rows > 0) {
            while ($row = $result_turnos->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["turno"] . "</option>";
            }
        }
        ?>
    </select>

    <label for="turno"><span class="selector-label">Tutor:</span></label>
    <select id="maestro" name="maestro" required>
    <?php
        // Generar opciones para el campo desplegable de maestros
        $sql_maestros = "SELECT id, nombre_completo FROM maestros";
        $result_maestros = $conn->query($sql_maestros);
        if ($result_maestros->num_rows > 0) {
            while ($row = $result_maestros->fetch_assoc()) {
                echo "<option value='" . $row["id"] . "'>" . $row["nombre_completo"] . "</option>";
            }
        }
        ?>
    </select>
</div>
<button class= "update-button">Actualizar</button>
<br>
<br>
<script>
  function updateSelectedValue() {
        var selectedValue = '';
        var selectors = document.querySelectorAll('.selector-group select');
        selectors.forEach(function(selector) {
            if (selector.value !== '') {
                selectedValue += selector.options[selector.selectedIndex].text + ' - ';
            }
        });
        selectedValue = selectedValue.slice(0, -2); // Eliminar la coma y el espacio extra al final
        document.querySelector('.selected-value').textContent = selectedValue;

        // Ocultar los selectores y las etiquetas
        selectors.forEach(function(selector) {
            selector.style.display = 'none';
        });
        var labels = document.querySelectorAll('.selector-label');
        labels.forEach(function(label) {
            label.style.display = 'none';
        });
    }

    // Agregar un evento de click al botón para actualizar el valor seleccionado
    var button = document.querySelector('.update-button');
    button.addEventListener('click', updateSelectedValue);

    document.getElementById('carreraSelect').addEventListener('change', function() {
    document.getElementById('carrera').src = "../images/" + this.value;
});
</script>
<?php
    echo "<table>";
    echo "<tr><th>Tabla ID</th><th>Hora de Inicio</th><th>Hora de Fin</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>";
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['tabla_id'] . "</td>";
            echo "<td>" . $row['hora_inicio'] . "</td>";
            echo "<td>" . $row['hora_fin'] . "</td>";
            echo "<td>" . $row['nombre_lunes'] . "</td>";
            echo "<td>" . $row['nombre_martes'] . "</td>";
            echo "<td>" . $row['nombre_miercoles'] . "</td>";
            echo "<td>" . $row['nombre_jueves'] . "</td>";
            echo "<td>" . $row['nombre_viernes'] . "</td>";
            echo "</tr>";
        }
    }
    echo "</table>";
} else {
    echo "Error preparing statement: " . $conn->error;
}

?>
<br>
<br>
<button id='printButton' class="no-print" onclick='window.print()'>Imprimir</button>
<br>
<button id='pdfButton' class="no-print">Descargar PDF</button>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script>
document.getElementById('pdfButton').addEventListener('click', function() {
    // Agrega CSS para ocultar elementos específicos
    var style = document.createElement('style');
    style.innerHTML = `
        h1, h2, h3, h4, h5, h6, p, a, button, input, select, textarea, .no-print, .selector-label {
            display: none !important;
        } 
            display: none !important; 
        }
        table { 
            transform: scale(0.7);  // Reduce el tamaño de la tabla al 70%
            transform-origin: top left; 
            margin-left: auto;  // Centra la tabla horizontalmente
            margin-right: auto; 
            margin-top: -30%;  // Mueve la tabla hacia abajo
        }
        .image-container {
            position: fixed;  // Cambia 'absolute' a 'fixed'
            top: 0;
            text-align: center; /* Centrar contenido horizontalmente */
            width: 100%;  // Asegura que el contenedor se extienda a lo ancho de la página
            z-index: 1000;  // Asegura que las imágenes estén por encima de otros elementos
        }

        /* Estilo para las imágenes */
        .image-container img {
            height: 70px;
            width: auto;
            margin: 0 20px; /* Espacio entre las imágenes */
        }

        #guerrero {
            height: 55px;
            width: auto;
        }
    `;
    document.head.appendChild(style);

    var opt = {
        margin: 1,
        filename: 'pagina.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
    };
    html2pdf().set(opt).from(document.body).save().then(function() {
        // Elimina el CSS después de que el PDF se haya generado
        document.head.removeChild(style);
    });
});
</script>
<br>
<button id='cancelButton' class="no-print" onclick="window.location.href = '../horariosup/horarios_guardados.php';">Cancelar</button>
</body>
</html>