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

        $estudios = [
            'Madhouse',
            'Toei Animation',
            'Bones',
            'Kyoto Animation',
            'Studio Ghibli'
        ];
    ?>
    <div class="container">
        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $tmp_titulo = depurar($_POST["titulo"]);
            $tmp_nombre_estudio = depurar($_POST["nombre_estudio"]);
            $tmp_anno_estreno = depurar($_POST["anno_estreno"]);
            $tmp_num_temporadas = depurar($_POST["num_temporadas"]);
        

            if($tmp_titulo == '') {
                $err_titulo = "El titulo es obligatorio";
            } else {
                if(strlen($tmp_titulo) > 80) { // verifica si tiene menos de 80 caracteres
                    $err_titulo = "El titulo debe contener menos de 80 carácteres";
                } else {
                    $titulo = $tmp_titulo;
                }
            }

            if($tmp_nombre_estudio == '') {
                $err_nombre_estudio = "El nombre del estudio es obligatorio";
            } else {
                $nombre_estudio = $tmp_nombre_estudio;
            }

            if ($tmp_anno_estreno && ($tmp_anno_estreno < 1960 || $tmp_anno_estreno > (date("Y") + 5))) {
                $err_anno_estreno = "El año de estreno no es válido";
            } else {
                $anno_estreno = $tmp_anno_estreno;
            }

            if($tmp_num_temporadas == ""){
                $err_num_temporadas = "El número de temporadas es obligatorio";
            } else {
                if ($tmp_num_temporadas < 1 || $tmp_num_temporadas > 99) {
                    $err_num_temporadas = "El número de temporadas no es válido";
                } else {
                    $num_temporadas = $tmp_num_temporadas;
                }
            }

        }
        ?>

    <h1>Formulario Anime</h1>

        <form class="col-4" action="" method="post">
            <div class="mb-3">
                <label class="form-label">Titulo</label>
                <input class="form-control" type="text" name="titulo">
                <?php if(isset($err_titulo)) echo "<span class='error'>$err_titulo</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre Estudio</label>
                <select name="nombre_estudio">
                <?php
                    foreach($estudios as $estudio) {
                        echo "<option value=".strtolower($estudio).">".$estudio."</option>"; //Lo pasa todo a minuscula
                    }
                ?>
                </select>
                <?php if(isset($err_nombre_estudio)) echo "<span class='error'>$err_nombre_estudio</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Año de estreno</label>
                <input class="form-control" type="text" name="anno_estreno">
                <?php if(isset($err_anno_estreno)) echo "<span class='error'>$err_anno_estreno</span>" ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Número de temporadas</label>
                <input class="form-control" type="text" name="num_temporadas">
                <?php if(isset($err_num_temporadas)) echo "<span class='error'>$err_num_temporadas</span>" ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Enviar">
            </div>
        </form>
        <?php
            if(isset($titulo) && isset($nombre_estudio) && isset($anno_estreno) && isset($num_temporadas)){ ?>
                <p><?php echo $titulo ?></p>
                <p><?php echo $nombre_estudio ?></p>
                <p><?php echo $anno_estreno ?></p>
                <p><?php echo $num_temporadas ?></p>
            <?php } ?>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>