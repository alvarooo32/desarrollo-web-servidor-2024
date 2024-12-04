<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
    <?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 );    
    ?>
</head>
<body>
    <!--Funcion que depura codigo-->
    <?php
        // string en parámetros para obligar a que entre un String
        // : string para 100% devolver un string 
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
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") {
                //Recibo todas las variable y la depuro del tiron
                $tmp_titulo = depurar($_POST["titulo"]);
                $tmp_paginas = depurar($_POST["paginas"]);
                $tmp_genero = depurar($_POST["genero"]);
                $tmp_escuela = depurar($_POST["escuela"]);
                $tmp_fecha_publicacion = depurar($_POST["fecha_publicacion"]);
                $tmp_sinopsis = depurar($_POST["sinopsis"]);



                if($tmp_titulo == '') { // El campo titulo no puede estar vacio
                    $err_titulo = "El nombre es obligatorio";
                } else {
                    // Mejor separar los errores para mejor experiencia del usuario
                    if(strlen($tmp_titulo) < 1 || strlen($tmp_titulo) > 40) { // verifica si la longitud de $tmp_nombre es menor de 2 o mayor de 40 caracteres / strlen() devuelve la longitud de la cadena
                        $err_titulo = "El nombre debe tener entre 2 y 40 caracteres";
                    } else {
                        // Letras, espacios en blanco y tildes
                        $patron = "/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ 0-9 .,;]+$/";
                        if(!preg_match($patron, $tmp_titulo)) {//verifica si el valor de $tmp_nombre no coincide con el formato definido en $patron
                            $err_titulo = "El nombre solo puede contener letras y espacios en blanco";
                        }
                    }
                }
                //Paginas
                if($tmp_paginas == '') { // El campo nombre no puede estar vacio
                    $err_paginas = "El numero es obligatorio";
                } else {
                    // Mejor separar los errores para mejor experiencia del usuario
                    if(strlen($tmp_paginas) < 10 || strlen($tmp_paginas) > 9999) { 
                        $err_titulo = "El numero de paginas no puede ser mayor de 9999 y menor de 10";
                    } 
                    
                }
                //Escuela
                if($tmp_escuela == '') {
                    $err_escuela = "La escuela es obligatoria";
                } else {
                    $escuelas_validos = ["general","reducido","superreducido"];
                    if(!in_array($tmp_escuela, $escuelas_validos)) {
                        $err_escuela = "No has seleccionado nada";
                    } else {
                        $escuela = $tmp_escuela;
                    }
                }

                //Fecha publicacion
                if ($tmp_fecha_publicacion == "") {
                    $err_fecha_publicacion = "La fecha de lanzamiento es obligatoria";
                } else {
                    $patron = "/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/";
                    if (!preg_match($patron, $tmp_fecha_publicacion)) { // verifica si una fecha no cumple con un formato específico
                        $err_fecha_publicacion = "Formato de fecha incorrecto";
                    } else {
                        list($anno_publicacion, $mes_publicacion, $dia_publicacion) = 
                            explode("-", $tmp_fecha_publicacion); //separacion de cadenas con un gion - de una cadena de fecha en sus componentes utilizando las funciones list() 
                        
                            if ($anno_publicacion < 1800) {
                            $err_fecha_publicacion = "El año no puede ser anterior a 1800";
                        } else {
                            $anno_actual = date("Y");
                            $mes_actual = date("m");
                            $dia_actual = date("d");
                        
                            if ($anno_publicacion - $anno_actual < 3) {
                                $fecha_publicacion = $tmp_fecha_publicacion;
                            } elseif ($anno_publicacion - $anno_actual > 3) {
                                $err_fecha_publicacion = "La fecha debe ser anterior a dentro de 3 años";
                            } elseif ($anno_publicacion - $anno_actual == 3) {
                                if ($mes_publicacion - $mes_actual < 0) {
                                    $fecha_publicacion = $tmp_fecha_publicacion;
                                } elseif ($mes_publicacion - $mes_actual > 0) {
                                    $err_fecha_publicacion = "La fecha debe ser anterior a dentro de 3 años";
                                } elseif ($mes_publicacion - $mes_actual == 0) {
                                    if ($dia_publicacion - $dia_actual <= 0) {
                                        $fecha_publicacion = $tmp_fecha_lanzamiento;
                                    } elseif ($dia_publicacion - $dia_actual > 0) {
                                        $err_fecha_publicacion = "La fecha debe ser anterior a dentro de 3 años";
                                    }
                                }
                            }
                        }
                    }
                }

                //Sinopsis
                if(strlen($tmp_sinopsis) < 0 || strlen($tmp_sinopsis) > 200) { // verifica si la longitud de $tmp_nombre es menor de 2 o mayor de 40 caracteres / strlen() devuelve la longitud de la cadena
                        $err_sinopsis = "El nombre debe tener entre 2 y 40 caracteres";
                } else {
                    // Letras, espacios en blanco y tildes
                    $patron = "/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ 0-9 .,;]+$/";
                    if(!preg_match($patron, $tmp_sinopsis)) {//verifica si el valor de $tmp_nombre no coincide con el formato definido en $patron
                        $err_sinopsis = "El nombre solo puede contener letras y espacios en blanco";
                    }
                    
                }
                

            }

        ?>
    </div>
    <h1>Formulario Ejercicio 1</h1>

    <form class="col-4" action="" method="post">
        <!--Titulo-->
        <div class="mb-3">
            <label class="form-label">Titulo:</label>
            <input class="form-control" type="text" name="titulo"><br><br>
            <?php if(isset($err_titulo)) echo "<span class='error'>$err_titulo</span>";//verifica si existe un mensaje de error relacionado con un titulo y lo muestra si está present muestra los errores?>
        </div>
        <!--Paginas-->
        <div class="mb-3">
            <label class="form-label">Paginas:</label>
            <input class="form-control" type="text" name="paginas"><br><br>
            <?php if(isset($err_paginas)) echo "<span class='error'>$err_paginas</span>";?>
        </div>

        <!--Genero-->
        <div class="mb-3">
            <label class="form-label">Genero:</label><br>
            <input type="radio" name="genero" value="fantasia">Fantasia <br> <!--Checked par que este marcado predeterminadamente-->
            <input type="radio" name="genero" value="cienciaFiccion">Ciencia Ficcion <br>
            <input type="radio" name="genero" value="romance">Romance <br>
            <input type="radio" name="genero" value="drama">Drama <br>

            <?php if(isset($err_genero)) echo "<span class='error'>$err_genero</span>";//verifica si existe un mensaje de error relacionado con un DNI y lo muestra si está present muestra los errores?>
        </div>

        <!--Escuela-->
        <div class="mb-3">
            <select name="escuela">
                <option disabled selected>--- TIENE ESCUELA? ---</option><!--muestra un mensaje predeterminado en un desplegable que no se puede seleccionar ni ver en la lista de opciones-->
                <option value="si">SI</option>
                <option value="no">NO</option>
            </select>
            <?php if(isset($err_escuela)) echo "<span class='error'>$err_escuela</span>";?>
        </div>

        <!--Fecha de publicacion-->
        <div class="mb-3">
            <label class="form-label">Fecha de publicaion</label>
            <input class="form-control" type="date" name="fecha_publicacion">
             <?php if(isset($err_fecha_publicacion)) echo "<span class='error'>$err_fecha_publicacion</span>"; ?>
        </div>

        <!--Sinopsis-->
        <div class="mb-3">
            <label class="form-label">Sinopsis:</label>
            <input class="form-control" type="text" name="sinopsis"><br><br>
            <?php if(isset($err_sinopsis)) echo "<span class='error'>$err_sinopsis</span>";?>
        </div>
        
        <!--Boton enviar-->
        <div class="mb-3">
            <input class="btn btn-primary" type="submit" value="Enviar">
        </div>

    </form>
    <?php
    if(isset($titulo) && isset($paginas) && isset($genero) && isset($escuela) && isset($fecha_publicacion) && isset($sinopsis) ) { //está realizando una verificación y luego mostrando información si ciertas variables están definidas. Muestra el resultado final?>
        <p><?php echo $titulo ?></p>
        <p><?php echo $paginas ?></p>
        <p><?php echo $genero ?></p>
        <p><?php echo $escuela ?></p>
        <p><?php echo $fecha_publicacion ?></p>
        <p><?php echo $sinopsis ?></p>


        
    <?php } ?>
    </div>
    
</body>
</html>