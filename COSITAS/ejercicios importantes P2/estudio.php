<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );  
    ?>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <?php
        function depurar(string $entrada) : string {
            $salida = htmlspecialchars($entrada);
            $salida = trim($salida);
            $salida = stripslashes($salida);
            $salida = preg_replace('!\s+!', ' ', $salida);
            return $salida;
        }
    ?>
    <div class="container">
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $tmp_nombre_estudio = depurar($_POST["nombre_estudio"]);
            $tmp_ciudad = depurar($_POST["ciudad"]);
        

            if($tmp_nombre_estudio == '') {
                $err_nombre_estudio = "El nombre del estudio es obligatorio";
            } else {
                $patron = "/^[a-zA-Z0-9 ]+$/";
                if(!preg_match($patron, $tmp_nombre_estudio)) {
                    $err_nombre_estudio = "El nombre del estudio solo puede contener letras, números y espacios en blanco";
                } else {
                    $nombre_estudio = $tmp_nombre_estudio;
                }
            }

            if($tmp_ciudad == '') {
                $err_ciudad = "La ciudad es obligatoria";
            } else {
                $patron = "/^[a-zA-Z ]+$/";
                if(!preg_match($patron, $tmp_ciudad)) {
                    $err_ciudad = "El nombre del estudio solo puede contener letras y espacios en blanco";
                } else {
                    $ciudad = $tmp_ciudad;
                }
            }

        }
        ?>

    <h1>Formulario Anime</h1>

        <form class="col-4" action="" method="post">
            <div class="mb-3">
                <label class="form-label">Nombre del estudio</label>
                <input class="form-control" type="text" name="nombre_estudio">
                <?php if(isset($err_nombre_estudio)) echo "<span class='error'>$err_nombre_estudio</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Ciudad</label>
                <input class="form-control" type="text" name="ciudad">
                <?php if(isset($err_ciudad)) echo "<span class='error'>$err_ciudad</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Enviar">
            </div>
        </form>
        <?php
            if(isset($nombre_estudio) && isset($ciudad)){ ?>
                <p><?php echo $nombre_estudio ?></p>
                <p><?php echo $ciudad ?></p>
            <?php } ?>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>