<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar categoria</title>
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
        .error {
            color: red;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Editar Categorias</h1>
        <?php
        $categoria = $_GET["categoria"];

        /*
        $sql = "SELECT * FROM categorias WHERE categoria = '$categoria'";
        $resultado = $_conexion -> query($sql);
        */

        //1. Preparacion            
        $sql = $_conexion -> prepare("SELECT * FROM categorias WHERE categoria = ?");

        //2. Enlazado
        $sql -> bind_param("s",$categoria);

        //3. Ejecución
        $sql -> execute();
        
        //4. Retrieve
        $resultado = $sql -> get_result();
        
        while($fila = $resultado -> fetch_assoc()) {
            $categoria = $fila["categoria"];
            $descripcion = $fila["descripcion"];
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $categoria = $_POST["categoria"];
            $descripcion = $_POST["descripcion"];   

            if($descripcion == ""){
                $err_descripcion = "La descripcion es obligatoria, no puede estar vacia";
            } else {
                if(strlen($descripcion) > 255){
                    $err_descripcion = "La descripcion no puede tener mas de 255 caracteres";
                } else{
                    // Modifica la descripcion si la descripcion no tiene mas de 255 caracteres
                    $sql = "UPDATE categorias SET descripcion = '$descripcion' 
                    WHERE categoria = '$categoria'";
                    $_conexion -> query($sql);
                }
            }
            
        }
        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <input class="form-control" type="text" name="categoria" value="<?php echo $categoria ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <textarea class="form-control" name="descripcion"><?php echo $descripcion ?></textarea>
                <?php if(isset($err_descripcion)) echo "<span class='error'>$err_descripcion</span>"; ?>
            </div>
            <div class="mb-3">
                <input type="hidden" name="categoria" value="<?php echo $categoria ?>">
                <input class="btn btn-primary" type="submit" value="Confirmar">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>