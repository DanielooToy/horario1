<?php
// Iniciar sesión si no está iniciada
session_start();

// Verificar si el formulario se envió correctamente
if(isset($_POST['registrar'])) {
    // Recuperar los datos del formulario
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Conectar a la base de datos
    $conexion = mysqli_connect("localhost", "root", "", "r_user");

    // Verificar la conexión
    if ($conexion === false) {
        die("ERROR: No se pudo conectar. " . mysqli_connect_error());
    }

    // Query para insertar el nuevo usuario
    $query = "INSERT INTO user (nombre, correo, telefono, password, rol) 
              VALUES ('$nombre', '$correo', '$telefono', '$password', '$rol')";

    // Ejecutar la consulta
    if (mysqli_query($conexion, $query)) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>
