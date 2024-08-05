<?php
// Datos de conexión a la base de datos
$host = "localhost"; // Host de la base de datos
$usuario = "root"; // Usuario de la base de datos
$contraseña = ""; // Contraseña de la base de datos
$base_de_datos = "r_user"; // Nombre de la base de datos

// Intentar establecer la conexión
$conexion = new mysqli($host, $usuario, $contraseña, $base_de_datos);

// Verificar si la conexión fue exitosa
if ($conexion->connect_errno) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.";
}

// Cerrar la conexión
$conexion->close();
?>