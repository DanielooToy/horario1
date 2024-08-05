<?php
require_once ("_db.php");

if (isset($_POST['accion'])) { 
    switch ($_POST['accion']) {
        case 'editar_registro':
            editar_registro();
            break; 

        case 'eliminar_registro':
            eliminar_registro();
            break;

        case 'acceso_user':
            acceso_user();
            break;
    }
}

function editar_registro() {
    $conexion = mysqli_connect("localhost", "root", "", "r_user");
    extract($_POST);
    $consulta = "UPDATE user SET nombre = '$nombre', correo = '$correo', telefono = '$telefono',
    password ='$password', rol = '$rol' WHERE id = '$id' ";

    mysqli_query($conexion, $consulta);
    header('Location: ../views/user.php');
    exit(); // Asegurarse de salir del script después de la redirección
}

function eliminar_registro() {
    $conexion = mysqli_connect("localhost", "root", "", "r_user");
    extract($_POST);
    $id = $_POST['id'];
    $consulta = "DELETE FROM user WHERE id= $id";

    mysqli_query($conexion, $consulta);
    header('Location: ../views/user.php');
    exit(); // Asegurarse de salir del script después de la redirección
}

function acceso_user() {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];
    session_start();
    $_SESSION['nombre'] = $nombre;

    $conexion = mysqli_connect("localhost", "root", "", "r_user");
    $consulta = "SELECT * FROM user WHERE nombre='$nombre' AND password='$password'";
    $resultado = mysqli_query($conexion, $consulta);
    $filas = mysqli_fetch_array($resultado);

    if ($filas) { // Si se encontraron resultados en la consulta
        if ($filas['rol'] == 1) { // Si el usuario es administrador
            header('Location: ../views/inicio.php');
            exit(); // Asegurarse de salir del script después de la redirección
        } else if ($filas['rol'] == 2) { // Si el usuario es lector
            header('Location: ../views/lector.php');
            exit(); // Asegurarse de salir del script después de la redirección
        }
    }

    // Si el usuario no está autenticado o los datos son incorrectos, redirigir de nuevo al formulario de inicio de sesión
    header('Location: index.php');
    session_destroy();
    exit(); // Asegurarse de salir del script después de la redirección
}
?>