<?php
// Recibe los datos del cliente
$data = json_decode(file_get_contents('php://input'), true);

// Crea el contenido del archivo CSV
$csvContent = "Hora Inicio,Hora Fin,Lunes,Martes,Miércoles,Jueves,Viernes\n";
foreach ($data as $row) {
    $csvContent .= implode(',', $row) . "\n";
}

// Establece las cabeceras para descargar el archivo
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="nombre_del_archivo.csv"');

// Envía el contenido del archivo CSV al cliente
echo $csvContent;
?>
