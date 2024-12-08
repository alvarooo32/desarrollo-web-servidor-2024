<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla Categoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );  

        require('../util/conexion.php');

        session_start();
        if (isset($_SESSION["usuario"])) { ?>
            <h2>Bienvenid@ <?php echo $_SESSION["usuario"] ?> </h2>
            <a class="btn btn-warning" href="../usuario/cerrar_sesion.php">Cerrar sesion</a>
            <a class="btn btn-primary" href="../usuario/cambiar_credenciales.php?usuario=<?php echo $_SESSION["usuario"] ?>">Cambiar Credenciales</a>
        <?php } else {
            header("location: ../usuario/iniciar_sesion.php");
            exit;
        } ?>
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
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $categoria = $_POST["categoria"];
            //si existen productos asociados a la categoría proporcionada.
            $sql="SELECT * FROM productos WHERE categoria ='$categoria'";
            $resultado=$_conexion -> query($sql);
            //si encuentra algun resultado no podras borrar la categoria 
            if($resultado -> num_rows >= 1){
                $err_borrar = "No puedes borrar la categoria si no borras los objetos asociados";
            } else {
                //si no encuentra ningun resultado  se podra eliminar la categoria
                $sql = "DELETE FROM categorias WHERE categoria = '$categoria'";
                $_conexion -> query($sql);
            }
            
        }

        $sql = "SELECT * FROM categorias";
        $resultado = $_conexion -> query($sql);
    ?>

    <div class="container">
        <h1>Tabla Categorias</h1>
        <div class="mb-3">
        <a href="nueva_categoria.php" class="btn btn-info">Agregar una categoría</a>
        <a href="../productos/index.php" class="btn btn-success">Ir a tabla Productos</a>
        </div>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Categoria</th>
                    <th>Descripcion</th>
                    <th></th><!--Para rellenar el hueco de los dos botones Editar y borrar-->
                    <th></th>
                </tr>
            </thead>
            <?php
                while ($fila = $resultado -> fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $fila["categoria"] . "</td>";
                    echo "<td>" . $fila["descripcion"] . "</td>";
                    ?>
                    <td>
                        <a  class="btn btn-primary" href="editar_categoria.php?categoria=<?php echo $fila["categoria"] ?>"> Editar</a>
                    </td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="categoria" value="<?php echo $fila["categoria"] ?>">
                            <input class="btn btn-danger" type="submit" value="Borrar">
                        </form>
                    </td>
                    <?php
                    echo "</tr>";
                }
            ?>
            </tbody>
        </table>
        <a href="../index.php" class="btn btn-outline-secondary">Volver a inicio</a>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>