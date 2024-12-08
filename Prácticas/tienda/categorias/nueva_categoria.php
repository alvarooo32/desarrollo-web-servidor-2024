<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 ); 
        require('../util/conexion.php'); 

        session_start();
        if (!isset($_SESSION["usuario"])) { 
            header("location: ../usuario/iniciar_sesion.php");
            exit;
        }
    ?>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <?php
        function depurar(string $entrada) : string {
            // Para que el usuario no pueda usar etiquetas en los campos Ej: <h1>Hola</h1>
            $salida = htmlspecialchars($entrada);
            // Para quitar los espacios de delante y detrás
            $salida = trim($salida);
            // Quita posibles bugs muy raros como que el usuario introduzca: \n (No está de más ponerla)
            $salida = stripcslashes($salida);
            // Para quitar los múltiples espacios entre variables y demás
            $salida = preg_replace('!\s+!', ' ', $salida);
            return $salida;
        }
    ?>
    <?php 
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $tmp_categoria = depurar($_POST["categoria"]);
            $tmp_descripcion = depurar($_POST["descripcion"]); 

            $sql="SELECT * FROM categorias WHERE categoria ='$tmp_categoria'";
            $resultado=$_conexion -> query($sql);

            if($resultado -> num_rows == 1){
                $err_categoria = "La categoria $tmp_categoria ya existe";
            }else{
                if($tmp_categoria == ''){
                    $err_categoria = "La categoría es obligatoria, no puede estar vacia";
                } else {
                    if(strlen($tmp_categoria) > 30){
                        $err_categoria = "La categoria no puede tener mas de 30 caracteres";
                    }elseif (strlen($tmp_categoria) < 2) {
                        $err_categoria = "La categoria no puede tener menos de 2 caracteres";
                    } 
                    else{
                        $categoria = $tmp_categoria;
                    }
                }
            }

            if($tmp_descripcion == "") {
                $error_descripcion = "Debes introducir una descripcion";
            } else {
                if(strlen($tmp_descripcion) > 255){
                    $error_descripcion = "El nombre de la categoria no puede tener mas de 255 caracteres";
                }else if(strlen($tmp_descripcion) < 2){
                    $error_descripcion = "El nombre de la categoria no puede tener menos de 2 caracteres";
                } else {
                    $patron ="/^[a-zA-Zaéíóú´AÉÍÓÚñÑ., ]{2,255}$/";

                if(!preg_match($patron, $tmp_descripcion)){
                    $error_descripcion = "El nombre solo puede contener letras y espacios";
                } else {
                    $descripcion = $tmp_descripcion;
                }
                
                }
                
            } 

            //Verifica que no este ni la descripcion ni la categoria vacia y si no lo esta las introduce en la base de datos
            if (isset($descripcion) && isset($categoria)){
                $sql = "INSERT INTO categorias (categoria, descripcion)
                    VALUES ('$categoria','$descripcion')";
                $_conexion -> query($sql);
            }
            
        }
    ?>

    <div class="container">
        <h1>Nueva Categoría</h1> 
        <form class="col-4" action="" method="post">
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <input type="text" class="form-control" name="categoria">
                <?php if(isset($err_categoria)) echo "<span class='error'>$err_categoria</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <textarea class="form-control" name="descripcion"></textarea>
                <?php if(isset($err_descripcion)) echo "<span class='error'>$err_descripcion</span>"; ?>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Insertar catergoria">
                <a href="index.php" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>