<body>
    <div class="container">
        <a class="btn btn-warning" href="usuario/cerrar_sesion.php">Cerrar sesión</a>
        <h1>Tabla de animes</h1>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                $id_anime = $_POST["id_anime"];
                echo "<h1>$id_anime</h1>";
                // Borrar el anime
                /* $sql = "DELETE FROM animes WHERE id_anime = $id_anime";
                $_conexion -> query($sql); */

                # 1. Prepare
                $sql = $_conexion -> prepare("DELETE FROM animes WHERE id_anime = ?");

                # 2. Enlazado
                $sql -> bind_param("i", $id_anime);

                #3. Execute
                $sql -> execute();

            }
            
            $sql = "SELECT * FROM animes";
            $resultado = $_conexion -> query($sql);

            $_conexion -> close();
            /**
             * Aplicamos la función query a la conexión, donde se ejecuta la sentencia SQL hecha
             * 
             * El resultado se almacena $resultado, que es un objeto con una estructura parecida
             * a los arrays
             */
        ?>
        <a href="nuevo_anime.php" class="btn btn-secondary">Crear nuevo anime</a><br><br>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Estudio</th>
                    <th>Año</th>
                    <th>Número de temporadas</th>
                    <th>Imagen</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($fila = $resultado -> fetch_assoc()) { //Trata el resultado como un array asociativo
                        echo "<tr>";
                        echo "<td>" . $fila["titulo"] . "</td>";
                        echo "<td>" . $fila["nombre_estudio"] . "</td>";
                        echo "<td>" . $fila["anno_estreno"] . "</td>";
                        echo "<td>" . $fila["num_temporadas"] . "</td>";
                        ?>
                        <td>
                            <img width="100" height="200" src="<?php echo $fila["imagen"]?>">
                        </td>
                        <td>
                            <a class="btn btn-primary" href="ver_anime.php?id_anime=<?php echo $fila["id_anime"] ?>">Editar</a>
                        </td>
                        <td>
                            <form action="" method="post">
                                <input type="hidden" name="id_anime" value="<?php echo $fila["id_anime"] ?>">    
                                <input class="btn btn-danger" type="submit" value="Borrar">
                            </form>
                        </td>
                        <?php
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>