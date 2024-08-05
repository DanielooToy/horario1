<?php
session_start();

// Verificar si el referer es una página interna
if (empty($_SERVER['HTTP_REFERER']) || !strpos($_SERVER['HTTP_REFERER'], $_SERVER['HTTP_HOST'])) {
    // Si no se refiere a una página interna, redirigir al usuario a la página principal (index.php)
    header('Location: index.php'); // Cambia 'index.php' por la página a la que deseas redirigir al usuario
    exit;
}

// Resto del código del formulario de inicio de sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <style>
        body {
            background-image: url('../images/fondo2.png'); /* Reemplaza 'tu_ruta' con la ruta correcta de tu imagen */
            background-size: cover;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #login-box {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 40px; /* Aumenta el padding interno */
            border-radius: 10px;
            width: 400px; /* Ancho del cuadro de login */
        }

        /* Estilos para los campos de entrada */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ced4da;
        }

        /* Estilos para el botón */
        input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-top: 12px;
            font-size: 16px;
            border-radius: 50px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            margin-left: 12px;
        }

        /* Estilos para el botón al pasar el cursor */
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>


<body id="page-top">


<form  action="./includes/validar.php" method="POST">
<div id="login" >
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                    
                            <br>
                            <br>
                            <h3 class="text-center">Registro de nuevo usuario</h3>
                            <div class="form-group">
                            <label for="nombre" class="form-label">Correo *</label>
                            <input type="text"  id="nombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Nombre:</label><br>
                                <input type="text" name="correo" id="correo" class="form-control" placeholder="">
                            </div>
                            <div class="form-group">
                                  <label for="telefono" class="form-label">Telefono *</label>
                                <input type="tel"  id="telefono" name="telefono" class="form-control" required>
                                
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label><br>
                                <input type="password" name="password" id="password" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                  <label for="rol" class="form-label">Rol de usuario *</label>
                                <input type="number"  id="rol" name="rol" class="form-control" placeholder="Escribe el rol, 1 admin, 2 lector..">
                             
                            </div>
                      
                        
                           <br>

                                <div class="mb-3">
                                    
                               <input type="submit" value="Guardar"class="btn btn-success" 
                               name="registrar">
                               <a href="./views/user.php" class="btn btn-danger">Cancelar</a>
                               
                            </div>
                            </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</body>
</html>

</body>
</html>
