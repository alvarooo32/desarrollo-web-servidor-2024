<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index de productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );    

        require('util/conexion.php');

        session_start();
        if (isset($_SESSION["usuario"])) {
            echo "<h2>Bienvenid@ " . $_SESSION["usuario"] . "</h2>";
            echo "<a class='btn btn-danger' href='./usuario/cerrar_sesion.php'>Cerrar sesión</a>";
            echo "<a  class='btn btn-info' href='./usuario/cambiar_credenciales.php' >Cambiar Credenciales</a>";
        } else {
            echo "<a class='btn btn-primary' href='./usuario/iniciar_sesion.php'>Iniciar sesión</a>";
        }
    ?>
    <style>
        .error {
            color: red;
            font-size: 12px
        }
        img{
            width: 160px;
            height: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tabla de productos</h1>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_anime = $_POST["id_producto"];
                echo "<h1>$id_producto</h1>";
                //  borrar el producto
                $sql = "DELETE FROM productos WHERE id_producto = $id_producto";
                $_conexion -> query($sql);
            }

            $sql = "SELECT * FROM productos";
            $resultado = $_conexion -> query($sql);
            /**
             * Aplicamos la función query a la conexión, donde se ejecuta la sentencia SQL hecha
             * 
             * El resultado se almacena $resultado, que es un objeto con una estructura parecida
             * a los arrays
             */
        ?>
        
            <?php 
                if (isset($_SESSION["usuario"])) { //Comprueba si existen un usuario en la sesion y te manda a productos
                    echo "<a class='btn btn-success' href='productos/index.php' class='btn btn-end'>Ir a tabla de productos</a>";
                }else {
                    echo "<a href='./productos/index.php' hidden>Productos</a>";
                } 
            ?>
            
        </div>
        
        <table class="table table-striped table-hover table text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Categoria</th>
                    <th>Stock</th>
                    <th>Imagen</th>
                    <th>Descripcion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($fila = $resultado -> fetch_assoc()) {    // trata el resultado como un array asociativo
                        echo "<tr>";
                        echo "<td>" . $fila["nombre"] ."</td>";
                        echo "<td>" . $fila["precio"] ."</td>";
                        echo "<td>" . $fila["categoria"] ."</td>";
                        echo "<td>" . $fila["stock"] ."</td>";
                        echo "<td>" . $fila["descripcion"] ."</td>";
                    ?>
                    <td>
                        <img src="./imagenes/<?php echo $fila["imagen"] ?>">                    
                    </td>
                    <?php
                    echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>