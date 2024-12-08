<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .error{
            color:red;
        }
    </style>
    <?php
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
        require('../util/conexion.php');
        session_start();
        function depurar(string $entrada) : string {
            $salida = htmlspecialchars($entrada); 
            $salida = trim($salida); 
            $salida = stripslashes($salida); 
            $salida = preg_replace('/\s+/', ' ', $salida); 
            return $salida; 
        }

    ?>
</head>
<body>
    <div class="container">
        <h1>Cambiar Contraseña</h1>
        <?php
        $usuario = $_SESSION["usuario"];
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        $resultado = $_conexion->query($sql);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $contrasena_actual = depurar($_POST["contrasena_actual"]);
            $nueva_contrasena = depurar($_POST["nueva_contrasena"]);
            $nueva_contrasena2 = depurar($_POST["nueva_contrasena2"]);

            if ($resultado->num_rows == 0) { //num_rows devuelve el numero de registros encontrados
                $err_usuario = "El usuario $usuario no existe.";
            } else {
                $datos_usuario = $resultado->fetch_assoc();
                if (password_verify($contrasena_actual, $datos_usuario["contrasena"])) {
                    if ($nueva_contrasena === $nueva_contrasena2) {
                        $hashed_contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
                        $sql_update = "UPDATE usuarios SET contrasena = '$hashed_contrasena' WHERE usuario = '$usuario'";
                        if ($_conexion->query($sql_update)) {
                            echo "<p class='text-success'>Contraseña actualizada correctamente.</p>";
                        } else {
                            echo "<p class='text-danger'>Error al actualizar la contraseña: " . $_conexion->error . "</p>";
                        }
                    } else {
                        $err_contrasena = "Las contraseñas no coinciden.";
                    }
                } else {
                    $err_contrasena_actual = "La contraseña actual es incorrecta.";
                }
            }
        }

        ?>

        
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Usuario</label>
                <input class="form-control" type="text" name="usuario" style="font-size: 14px;" value="<?php echo "$usuario" ?>" disabled>
            </div>
            <div class="mb-3">
                <label>Contraseña Actual</label>
                <input class="form-control" type="password" name="contrasena_actual">
                <?php if (isset($err_contrasena_actual)) echo "<span class='error'>$err_contrasena_actual</span>" ?>
            </div>
            <div class="mb-3">
                <label>Nueva Contraseña</label>
                <input class="form-control" type="password" name="nueva_contrasena">
            </div>
            <div class="mb-3">
                <label class="form-label">Repite Nueva Contraseña</label>
                <input class="form-control" type="password" name="nueva_contrasena2">
                <?php if (isset($err_contrasena)) echo "<span class='error'>$err_contrasena</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Cambiar Contraseña">
                <a class="btn btn-secondary" href="../index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>