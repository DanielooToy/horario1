<?php
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
        // Si se guarda correctamente, redirigir a la página de usuarios
        header("Location: ../views/user.php");
        exit();
    } else {
        echo "Error al registrar el usuario: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
}
?>

<!DOCTYPE html>
<html lang="es-MX">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #f7f7f7;
        }
        form {
            margin: 0 auto;
            width: 50%;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }
        h3 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"], .btn {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-transform: uppercase;
        }
        input[type="submit"]:hover, .btn:hover {
            background-color: #45a049;
        }
        .btn-danger {
            background-color: #d9534f;
        }
    </style>
</head>
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <h3 class="text-center">Registro de nuevo usuario</h3>
                        <div class="form-group">
                            <label for="nombre">Correo *</label>
                            <input type="text" id="nombre" name="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="correo">Nombre:</label>
                            <input type="text" name="correo" id="correo" class="form-control" placeholder="">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Telefono *</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña:</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol de usuario *</label>
                            <select class="form-select" id="rol" name="rol" required>
                                <option value="1">Administrador</option>
                                <option value="2">Lector</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="submit" value="Guardar" class="btn btn-success" name="registrar">
                          <br>
                          <br>
                          <br>
                            <a href="../views/user.php" class="btn btn-danger">Cancelar</a>
    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

</body>
</html>
