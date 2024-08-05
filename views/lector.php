<?php
session_start();
error_reporting(0);

$validar = $_SESSION['nombre'];

if ($validar == null || $validar == '') {
    header("Location: ../includes/login.php");
    die();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "r_user";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Obtén todos los nombres de las materias en una sola consulta
$materias = $conn->query("SELECT id, nombre_materia FROM materias")->fetch_all(MYSQLI_ASSOC);
$materias = array_column($materias, 'nombre_materia', 'id');

// Consulta a la base de datos para obtener las filas de la tabla horarios

$result = $conn->query("SELECT * FROM horarios ORDER BY tabla_id");

if ($result && $result->num_rows > 0) {
    // Obtén las filas como un array asociativo
    $rows = $result->fetch_all(MYSQLI_ASSOC);

    echo '<div class="search-container">';
    echo '<label for="search">Buscar Tabla ID:</label>';
     echo '<input type="text" id="search" onkeyup="searchTablas()" placeholder="Ingrese el ID de la tabla">';
  echo '<a href="../includes/_sesion/cerrarSesion.php" class="cancel-button">Cerrar Sesión</a>';
    echo '</div>';

    $current_tabla_id = null;
    foreach ($rows as $row) {
        if ($current_tabla_id != $row['tabla_id']) {
            if ($current_tabla_id != null) {
                // End the previous table
                echo "</table><br>";
            }
            // Start a new table
            echo "<table id='myTable" . $row['tabla_id'] . "'>";
            // Print the table headers for each new table
            echo '<tr><th>Tabla ID</th><th>Acción</th><th>Hora de Inicio</th><th>Hora de Fin</th><th>Lunes</th><th>Martes</th><th>Miércoles</th><th>Jueves</th><th>Viernes</th></tr>';
            $current_tabla_id = $row['tabla_id'];
        }
        // Print the row
        echo "<tr><td>" . $row['tabla_id'] . "</td>";

        echo "<td><button class='imprimir' data-id='" . $row['tabla_id'] . "'>Imprimir</button> </td>";

echo "<td>" . $row['hora_inicio'] . "</td><td>" . $row['hora_fin'] . "</td>";
        foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes'] as $dia) {
            if (isset($row[$dia]) && isset($materias[$row[$dia]])) {
                echo "<td>" . $materias[$row[$dia]] . "</td>";
            } else {
                echo "<td></td>"; // Print an empty cell if the key does not exist
            }
        }
        echo "</tr>";
    }
    // End the last table
    echo "</table>";
    
} else {
    echo '<div style="text-align: center; margin-top: 400px;">';
    echo '<h2>OH NO!!! Parece que no hay horaros disponibles....todavía</h2>';
   
    echo '<a href="../includes/_sesion/cerrarSesion.php" class="cancel-button" >Cerrar Sesión</a>';

    // Ajusta el ancho y la altura aquí
    echo '<div style="position: relative; width: 43%; height: 0; padding-bottom: 24.125%; margin: auto;">';
    echo '<video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;">';
    echo '<source src="../images/nube.mp4" type="video/mp4">';
    echo '</video>';
    echo '</div>';
}


$conn->close();
?>

<script>
function searchTablas() {
    var input, filter, tables, tr, td, i, j, txtValue;
    input = document.getElementById("search");
    filter = input.value.toUpperCase();
    tables = document.getElementsByTagName("table");
    for (j = 0; j < tables.length; j++) {
        tr = tables[j].getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }
}
function imprimir(tabla_id) {
    // Aquí puedes redirigir al usuario a una página de edición con el ID de la tabla como parámetro
    window.location.href = "imprimir_lector.php?tabla_id=" + tabla_id;
}


document.addEventListener('DOMContentLoaded', function() {
    // Assign click events to the print, edit, and delete buttons
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('imprimir')) {
            imprimir(event.target.getAttribute('data-id'));
        } else if (event.target.classList.contains('editar')) {
            editarHorario(event.target.getAttribute('data-id'));
        } else if (event.target.classList.contains('eliminar')) {
            eliminar(event.target.getAttribute('data-id'));
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Assign click events to the print, edit, and delete buttons
    document.body.addEventListener('click', function(event) {
        if (event.target.classList.contains('imprimir')) {
            imprimir(event.target.getAttribute('data-id'));
        } else if (event.target.classList.contains('editar')) {
            editarHorario(event.target.getAttribute('data-id'));
        } else if (event.target.classList.contains('eliminar')) {
            eliminar(event.target.getAttribute('data-id'));
        }
    });
});
</script>
<style>
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.search-container {
    margin-bottom: 20px;
}


table {
    width: 2000px; /* Ancho fijo */
    height: 100px; /* Altura fija */
    border-collapse: collapse;
    margin-bottom: 60px;
    table-layout: fixed; /* Esto hace que las columnas tengan el mismo tamaño */
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    overflow: hidden; /* Esto oculta el contenido que excede el tamaño de la celda */
    text-overflow: ellipsis; /* Esto agrega puntos suspensivos al final del contenido que excede el tamaño de la celda */
}

th {
    background-color: #4CAF50;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

.search-container {
    margin-bottom: 20px;
}



.search-container {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.search-container label {
    margin-right: 10px;
    font-size: 1.2em;
    line-height: 2;
}

.search-container input[type="text"] {
    padding: 5px 10px;
    font-size: 1.2em;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.search-container input[type="text"]:focus {
    outline: none;
    border-color: #4CAF50;
}

/* Estilos para los botones */
button.editar, button.eliminar, button.Imprimir {
    padding: 5px 10px;
    margin: 3px;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
}

button.editar {
    background-color: #4CAF50;
   
}

button.eliminar {
    background-color: #d90800;
    
}

button.Imprimir {
    background-color: #ff6600;
   
}

button.editar:hover, button.eliminar:hover {
    opacity: 0.8;
}
.cancel-button {
        display: inline-block;
        margin-top: 10px;
        padding: 10px 20px;
        background-color: #ff3229; /* blue */
        background-color: #; /* Red */
        color: white;
        text-decoration: none;
        border-radius: 4px;
        text-align: center;
    }

    .cancel-button:hover {
        background-color: #296eff; /* Darker red */
    }


</style>