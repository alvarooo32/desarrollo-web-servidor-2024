<!DOCTYPE html>
<html lang="en">
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
    <div class="container">
        <h1>Editar producto</h1>
        <?php
        $id_producto = $_GET["id_producto"];
        $sql = "SELECT * FROM productos WHERE id_producto = '$id_producto'";
        $resultado = $_conexion -> query($sql);
        
        while($datos = $resultado -> fetch_assoc()) {
            $nombre_actual = $dato_actual["nombre"];
            $precio_actual = $dato_actual["precio"];
            $categoria_actual = $dato_actual["categoria"];
            $stock_actual = $dato_actual["stock"];
            $descripcion_actual = $dato_actual["descripcion"];
        }
        $sql = "SELECT * FROM categorias ORDER BY categoria";
        $resultado = $_conexion -> query($sql);
        $categorias = [];

        while($fila = $resultado -> fetch_assoc()) {
            array_push($categorias, $fila["categoria"]);
        }

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $tmp_nombre = depurar($_POST["nombre"]);
            $tmp_precio = depurar($_POST["precio"]);
            $tmp_categoria = depurar($_POST["categoria"]);
            $tmp_stock = depurar($_POST["stock"]);
            $tmp_descripcion = depurar($_POST["descripcion"]);

            //Validacion nombre
            if($tmp_nombre == ''){
                $err_nombre = "El nombre es obligatorio";
            } else {
                if(strlen($tmp_nombre) > 51){
                    $err_nombre = "El nombre es de 50 caracteres maximo";
                }elseif (strlen($tmp_nombre) < 1) {
                    $err_nombre = "El nombre es de 2 caracteres minimo";
                }
                 else {
                    $patron = "/^[0-9a-zA-Z áéíóúÁÉÍÓÚ]+$/";
                    if(!preg_match($patron, $tmp_nombre)){
                        $err_nombre = "El nombre solo puede tener letras, numeros y espacios";
                    } else {//actualizo nombre en bd
                        $sql = "UPDATE productos SET nombre = '$tmp_nombre' WHERE nombre = '$nombre_actual'";
                        $_conexion -> query($sql);
                        $nombre_actual = $tmp_nombre;
                    }
                }
            }

            //Validación precio 
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
                        } else {//actualizo precio en bd
                            $sql = "UPDATE productos SET precio = '$tmp_precio' WHERE precio = '$precio'";
                            $_conexion -> query($sql);
                            $precio = $tmp_precio;
                        }
                    }   
                }
            }

            //Validación categoria 
            if ($tmp_categoria == "") {
                $categoria_nueva = $categoria_original;
            } else {
                if (strlen($tmp_categoria) > 30) {
                    $err_categoria = "La categoría debe tener un máximo de 30 caracteres.";
                } elseif (!in_array($tmp_categoria, $lista_categorias)) {
                    $err_categoria = "La categoría no es válida.";
                } else { //actualizo categoria en bd
                    $sql = "UPDATE productos SET categoria = '$tmp_categoria' WHERE id_producto = '$id_producto'";
                    $_conexion -> query($sql);
                    $categoria = $tmp_categoria;
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
                        $sql = "UPDATE productos SET stock = $tmp_stock WHERE id_producto = '$id_producto'";
                        $_conexion -> query($sql);
                        $stock = $tmp_stock;
                    }
                }
            }
             /* Validación descripción */
             if ($tmp_descripcion == "") {
                $err_descripcion = "La descripción es obligarotía";
            } else {
                if (strlen($tmp_descripcion) > 255) {
                    $err_descripcion = "La descripción debe tener un máximo del 255 caracteres.";
                } else {
                    // actualizo descripcion en bd
                    $sql = "UPDATE productos SET descripcion = '$tmp_descripcion' WHERE descripcion = '$descripcion_actual'";
                    $_conexion -> query($sql);
                    $descripcion_actual = $_descripcion;
                }
            }
            
        }

        ?>
        <form class="col-6" action="" method="post" enctype="multipart/form-data"><!--enctype="multipart/form-data => para que pueda incluir fotos-->
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" type="text" name="tmp_nombre" value="<?php echo $nombre_actual ?>">
                <?php if(isset($err_nombre)) echo "<span class='error'>$err_nombre</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Precio</label>
                <input class="form-control" type="text" name="tmp_precio" value="<?php echo $precio_actual ?>">
                <?php if(isset($err_precio)) echo "<span class='error'>$err_precio</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Categorias</label>
                <select class="form-select" name="nueva_categoria">
                    <option value="<?php echo $categoria_actual ?>" selected><?php echo $categoria_actual ?></option>
                    <?php 
                    foreach($categorias as $categoria) { ?>
                        <?php if($categoria != $categoria_actual){ ?>
                            <option value="<?php echo $categoria ?>">
                                <?php echo $categoria; ?>
                            </option>
                        <?php } ?>
                    <?php } ?>
                </select>
                <?php if(isset($err_categoria)) echo "<span class='error'>$err_categoria</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input class="form-control" type="text" name="tmp_stock" value="<?php echo $stock_actual ?>">
                <?php if(isset($err_stock)) echo "<span class='error'>$err_stock</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripcion</label>
                <textarea class="form-control" name="nueva_descripcion"><?php echo $descripcion_actual ?></textarea>
                <?php if(isset($err_descripcion)) echo "<span class='error'>$err_descripcion</span>"; ?>
            </div>
            <div class="mb-3">
                <input type="hidden" name="id_producto" value="<?php echo $id_producto ?>">
                <input class="btn btn-primary" type="submit" value="Confirmar">
                <a class="btn btn-secondary" href="index.php">Volver</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>