<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo producto</title>
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
        img{
            width: 160px;
            height: 200px;
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
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $tmp_nombre = depurar($_POST["nombre"]);
        $tmp_precio = depurar($_POST["precio"]);
        if(isset($_POST["categoria"])) $tmp_categoria = depurar($_POST["categoria"]);
        else $tmp_categoria = "";
        $tmp_stock = depurar($_POST["stock"]);
        $tmp_descripcion = depurar($_POST["descripcion"]);

        $nombre_imagen = $_FILES["imagen"]["name"];
        $ubicacion_temporal = $_FILES["imagen"]["tmp_name"];
        $ubicacion_final = "../imagenes/$nombre_imagen";

        //Validacion Nombre
        if ($tmp_nombre == "") {
            $err_nombre = "El nombre es obligatorio.";
        } else {
            if (strlen($tmp_nombre) > 50) {
                $err_nombre = "El nombre debe tener como maximo 50 caracteres.";
            }else if(strlen($tmp_nombre) < 2 ){
                $err_nombre = "El nombre debe tener como minimo 2 caracteres.";
            } else {
                $patron_nombre = "/^[a-zA-Z0-9 ]+/";
                if (!preg_match($patron_nombre, $tmp_nombre)) {
                    $err_nombre = "El nombre solo puede tener letras, números y espacios en blanco.";
                } else {
                    $nombre = $tmp_nombre;
                }
            }
        }
        
        //Validacion precio
        if ($tmp_precio == "") {
            $err_precio = "El precio es obligatorio.";
        } else {
            if (!is_numeric($tmp_precio)) {
                $err_precio = "El precio debe ser numérico";
            } else {
                if ($tmp_precio < 0 || $tmp_precio > 2147483647) {
                    $err_precio = "El precio debe ser mayor a 0 y menor a 2.147.483.647.";
                } else {
                    $patron_precio = "/^[0-9]{1,4}(\.[0-9]{1,2})?$/";
                    if (!preg_match($patron_precio, $tmp_precio)) {
                        $err_precio = "El rango de precio es de 0 hasta 9999.99";
                    } else {
                        $precio = $tmp_precio;
                    }
                }   
            }
        }

        //validacon categoria
        if ($tmp_categoria == "") {
            $err_categoria = "La categoría es ogligatoria.";
        } else {
            if (strlen($tmp_categoria) > 30) {
                $err_categoria = "La categoría debe tener un máximo del 30 caracteres.";
            } else {
                $sql = "SELECT * FROM categorias";
                $resultado_categoria = $_conexion -> query($sql);
                $lista_categorias = [];

                while ($fila = $resultado_categoria -> fetch_assoc()) {
                    $lista_categorias[] = $fila['categoria'];
                }

                if (!in_array($tmp_categoria, $lista_categorias)) {
                    $err_categoria = "La categoría no es válida";
                } else {
                    $categoria = $tmp_categoria;
                }
            }
        } 

        //Validacion stock
        if ($tmp_stock == "") {
            $stock = intval($tmp_stock);
        } else {
            if (!is_numeric($tmp_stock)) {
                $err_stock = "El stock debe ser numérico";
            } else {
                if ($tmp_stock < 0 || $tmp_stock > 2147483647) {
                    $err_stock = "El stock debe ser mayor a 0 y menor a 2.147.483.647.";
                } else {
                    $stock = $tmp_stock;
                }
            }
        }

        //Validacion Imagen
        if($nombre_imagen == ""){
            $err_imagen = "La imagen es obligatoria";
        } else {
            if(strlen($nombre_imagen) > 60){
                $err_imagen = "La ruta de la imagen no puede tener mas de 60 caracteres";
            } else {
                move_uploaded_file($ubicacion_temporal, $ubicacion_final);
                $imagen = $nombre_imagen;
            }
        }
        

        /* Validación descripción */
        if($tmp_descripcion == ''){
            $err_descripcion = "La descripcion es obligatoria";
        } else {
            if(strlen($tmp_descripcion) > 255){
                $err_descripcion = "La descripcion no puede tener mas de 255 caracteres";
            } else{
                $descripcion = $tmp_descripcion;
            }
        }

        if (isset($nombre) && isset($precio) && isset($categoria) && isset($imagen) && isset($descripcion)){
            // Inserta un nuevo producto
            $sql = "INSERT INTO productos (nombre, precio, categoria, stock, imagen, descripcion)
            VALUES ('$nombre', $precio, '$categoria', $stock, '$imagen', '$descripcion')";
            $_conexion -> query($sql);
        }
        
    }

    $sql = "SELECT * FROM categorias ORDER BY categoria";
    $resultado = $_conexion -> query($sql);
    $categorias = [];

    while($fila = $resultado -> fetch_assoc()) {
        array_push($categorias, $fila["categoria"]);
    }

    ?>
    <div class="container">
        <h1>Nuevo Producto</h1>
        <form class="col-5" action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" type="text" name="nombre">
                <?php if(isset($err_nombre)) echo "<span class='error'>$err_nombre</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input class="form-control" type="text" name="precio">
                <?php if(isset($err_precio)) echo "<span class='error'>$err_precio</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Categorias</label>
                <select class="form-select" name="categoria">
                    <option selected disabled hidden>--- Elige una categoria ---</option>
                    <?php 
                    foreach($categorias as $categoria) { ?>
                        <option value="<?php echo $categoria ?>">
                            <?php echo $categoria ?>
                        </option>
                    <?php } ?>
                </select>
                <?php if(isset($err_categoria)) echo "<span class='error'>$err_categoria</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input class="form-control" type="text" name="stock">
                <?php if(isset($err_stock)) echo "<span class='error'>$err_stock</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Imagen</label>
                <input class="form-control" type="file" name="imagen">
                <?php if(isset($err_imagen)) echo "<span class='error'>$err_imagen</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <textarea class="form-control" name="descripcion"></textarea>
                <?php if(isset($err_descripcion)) echo "<span class='error'>$err_descripcion</span>"; ?>
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Insertar producto">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>