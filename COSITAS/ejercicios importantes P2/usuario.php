<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuario</title>
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
        <!-- Content here -->

        <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            //CRecibo todas las variable y la depuro del tiron
            $tmp_usuario = depurar($_POST["usuario"]);
            $tmp_nombre = depurar($_POST["nombre"]);
            $tmp_apellidos = depurar($_POST["apellidos"]);
            $tmp_dni = depurar($_POST["dni"]);
            $tmp_correo = depurar($_POST["correo"]);
            $tmp_fecha_nacimiento = depurar($_POST["fecha_nacimiento"]);
            $tmp_fecha_primer_dni = depurar($_POST["fecha_primer_dni"]);

            //Se puden comparar strings como si fueran numeros (nos quita mucho trabajo);
            if ($tmp_fecha_nacimiento > $tmp_fecha_primer_dni) {
                echo "<h1>La fecha de nacimiento no puede ser posterior a la del DNI</h1>";
            } else if ($tmp_fecha_nacimiento == $tmp_fecha_primer_dni) {
                echo "<h1>La fecha de nacimiento es igual a la del DNI</h1>";
            } else {
                echo "<h1>Ok,la fecha está bien</h1>";
            }

            if($tmp_dni == '') { //DNI no puede estar vacio
                $err_dni = "El DNI es obligatorio"; //Guardo los posible errores en una variable para dps mostrarlos
            } else {
                // Lo convierto a mayúscula para comprobarlo una vez sea mayúscula
                $tmp_dni = strtoupper($tmp_dni);//convierte el valor de $tmp_dni a mayúsculas para asegurar un formato consistente en la validación del DNI.
                $patron = "/^[0-9]{8}[A-Z]$/"; 
                if(!preg_match($patron,$tmp_dni)) { //verifica si el valor de $tmp_dni no coincide con el formato definido en $patron
                    $err_dni = "El DNI debe tener 8 dígitos y una letra";
                } else {
                    // Cogemos los 8 números con substr (también vale 0, -1);
                    $numero_dni = (int)substr($tmp_dni,0,8); //La línea extrae los primeros 8 dígitos de $tmp_dni y los convierte en un número entero.
                    $letra_dni = substr($tmp_dni,8,1); //extrae un carácter en la posición 8 de $tmp_dni, que corresponde a la letra del DNI.

                    $resto_dni = $numero_dni % 23;//resto de la división del número del DNI entre 23, lo que se usa para determinar la letra correspondiente del DNI.

                    //Opción menos optimizada (más facil de pensar);
                    /*
                    $letra_correcta = match($resto_dni) {
                        0 => "T",
                        1 => "R",
                        2 => "W",
                        3 => "A",
                        4 => "G",
                        5 => "M",
                        6 => "Y",
                        7 => "F",
                        8 => "P",
                        9 => "D",
                        10 => "X",
                        11 => "B",
                        12 => "N",
                        13 => "J",
                        14 => "Z",
                        15 => "S",
                        16 => "Q",
                        17 => "V",
                        18 => "H",
                        19 => "L",
                        20 => "C",
                        21 => "K",
                        22 => "E"
                    };
                    */

                    // Opción optimizada (algo más complicada de pensar);
                    $letras_dni = "TRWAGMYFPDXBNJZSQVHLCKE";

                    // Coge $letras_dni, va a la posición $resto_dni y extrae ese caracter
                    $letra_correcta = substr($letras_dni,$resto_dni,1);

                    if($letra_dni != $letra_correcta) {
                        $err_dni = "La letra del DNI no es correcta";
                    } else {
                        $dni = $tmp_dni;
                    }
                }
            }

            if($tmp_correo == '') { // El correo no puede estar vacio
                $err_correo = "El correo electrónico es obligatorio";
            } else {
                // Formato de correo electrónico
                $patron = "/^[a-zA-Z0-9_\-.+]+@([a-zA-Z0-9-]+.)+[a-zA-Z]+$/";
                if(!preg_match($patron, $tmp_correo)) {//verifica si el valor de $tmp_correo no coincide con el formato definido en $patron
                    $err_correo = "El correo no es válido";
                } else {
                    $palabras_baneadas = ["caca","peo","recorcholis","caracoles","repampanos"];

                    $palabras_encontradas = "";
                    // Recorremos el array de palabras prohibidas
                    foreach($palabras_baneadas as $palabra_baneada) {
                        // Si el correo contiene la palabra prohibida, la agregamos a la lista de palabras encontradas
                        if(str_contains($tmp_correo, $palabra_baneada)) { // verificar si una cadena de texto contiene una subcadena específica
                            $palabras_encontradas = "$palabra_baneada, " . $palabras_encontradas;
                        }
                    }
                    // Si se encontraron palabras prohibidas, asignamos un mensaje de error
                    if($palabras_encontradas != '') {
                        $err_correo = "No se permiten las palabras: $palabras_encontradas";
                    } else {
                        // Si no se encontraron palabras prohibidas, guardamos el correo
                        $correo = $tmp_correo;
                    }
                }
            }

            if($tmp_usuario == '') { // El campo usuario no puede estar vacio
                $err_usuario = "El usuario es obligatorio";
            } else {
                // A-Z (mayus o minus), números, barrabaja (4-12 chars)
                // Tiene que ir entre /^$/
                $patron = "/^[a-zA-Z0-9_]{4,12}$/";
                // Comprueba si existe el patron en $tmp_usuario
                if(!preg_match($patron, $tmp_usuario)) { //verifica si el valor de $tmp_usuario no coincide con el formato definido en $patron
                    $err_usuario = "El usuario debe contener de 4 a 12 letras, 
                        números o barrabaja";
                } else {
                    $usuario = $tmp_usuario;
                }
            }

            if($tmp_nombre == '') { // El campo nombre no puede estar vacio
                $err_nombre = "El nombre es obligatorio";
            } else {
                // Mejor separar los errores para mejor experiencia del usuario
                if(strlen($tmp_nombre) < 2 || strlen($tmp_nombre) > 40) { // verifica si la longitud de $tmp_nombre es menor de 2 o mayor de 40 caracteres / strlen() devuelve la longitud de la cadena
                    $err_nombre = "El nombre debe tener entre 2 y 40 caracteres";
                } else {
                    // Letras, espacios en blanco y tildes
                    $patron = "/^[a-zA-Z áéióúÁÉÍÓÚñÑüÜ]+$/";
                    if(!preg_match($patron, $tmp_nombre)) {//verifica si el valor de $tmp_nombre no coincide con el formato definido en $patron
                        $err_nombre = "El nombre solo puede contener letras y espacios en blanco";
                    } else {
                        // ucwords para poner la primera letra en mayúscula
                        $nombre = ucwords(strtolower($tmp_nombre));//convierte el texto a minúsculas y luego pone en mayúscula la primera letra de cada palabra.
                    }
                }
            }

            if ($tmp_apellidos == '') {
                $err_apellidos = "Los apellidos son obligatorios";
            } else {
                // Mejor separar los errores para mejor exp del usuario
                if (strlen($tmp_apellidos) < 2 or strlen($tmp_apellidos) > 40) {// verifica si la longitud de $tmp_nombre es menor de 2 o mayor de 40 caracteres / strlen() devuelve la longitud de la cadena
                    $err_apellidos = "Los apellidos deben tener entre 2 y 40 caracteres";
                } else {
                    // Letras, espacios en blanco y tildes
                    $patron = "/^[a-zA-Z àèìòùÀÈÌÒÙñÑüÜ]+$/";
                    if (!preg_match($patron, $tmp_apellidos)) {//verifica si el valor de $tmp_apellidos no coincide con el formato definido en $patron
                        $err_apellidos = "Los apellidos solo pueden contener letras y espacios en blanco";
                    } else {
                        $apellidos = $tmp_apellidos;
                    }
                }
            }

            if($tmp_fecha_nacimiento == '') {
                $err_fecha_nacimiento = "La fecha de nacimiento es obligatoria";
            } else {
                $patron = "/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/";
                if(!preg_match($patron, $tmp_fecha_nacimiento)) { //verifica si el valor de $tmp_frcha de nacimiento no coincide con el formato definido en $patron
                    $err_fecha_nacimiento = "Formato de fecha incorrecto";
                } else {
                    $fecha_actual = date("Y-m-d");
                    // Asigna variables a los 3 campos (Y-M-D) del explode (explode == split)
                    list($anno_actual,$mes_actual,$dia_actual) = explode('-',$fecha_actual);
                    list($anno,$mes,$dia) = explode('-',$tmp_fecha_nacimiento);

                    if($anno_actual - $anno < 18) {
                        $err_fecha_nacimiento = "No puedes ser menor de edad";
                    } elseif($anno_actual - $anno == 18) {
                        if($mes_actual - $mes < 0) {
                            $err_fecha_nacimiento = "No puedes ser menor de edad";
                        } elseif($mes_actual - $mes == 0) {
                            if($dia_actual - $dia < 0) {
                                $err_fecha_nacimiento = "No puedes ser menor de edad";
                            } else {
                                $fecha_nacimiento = $tmp_fecha_nacimiento;
                            }
                        } elseif($mes_actual - $mes > 0) {
                            $fecha_nacimiento = $tmp_fecha_nacimiento;
                        } 
                    } elseif($anno_actual - $anno > 121) {
                        $err_fecha_nacimiento = "No puedes tener más de 120 años";
                    } elseif($anno_actual - $anno == 121) {
                        if($mes_actual - $mes > 0) {
                            $err_fecha_nacimiento = "No puedes tener más de 120 años";
                        } elseif($mes_actual - $mes == 0) {
                            if($dia_actual - $dia >= 0) {
                                $err_fecha_nacimiento = "No puedes tener más de 120 años";
                            } else {
                                $fecha_nacimiento = $tmp_fecha_nacimiento;
                            }
                        } elseif($mes_actual - $mes < 0) {
                            $fecha_nacimiento = $tmp_fecha_nacimiento;
                        } 
                    } else {
                        $fecha_nacimiento = $tmp_fecha_nacimiento;
                    }
                }
            }
        }
        ?>

        <h1>Formulario usuario</h1>

        <form class="col-4" action="" method="post">
            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input class="form-control" type="text" name="dni">
                <?php if(isset($err_dni)) echo "<span class='error'>$err_dni</span>";//verifica si existe un mensaje de error relacionado con un DNI y lo muestra si está present muestra los errores?>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo electrónico</label>
                <input class="form-control" type="text" name="correo">
                <?php if(isset($err_correo)) echo "<span class='error'>$err_correo</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input class="form-control" type="text" name="usuario">
                <?php if(isset($err_usuario)) echo "<span class='error'>$err_usuario</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input class="form-control" type="text" name="nombre">
                <?php if(isset($err_nombre)) echo "<span class='error'>$err_nombre</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellidos</label>
                <input class="form-control" type="text" name="apellidos">
                <?php if(isset($err_apellidos)) echo "<span class='error'>$err_apellidos</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de nacimiento</label>
                <input class="form-control" type="date" name="fecha_nacimiento">
                <?php if(isset($err_fecha_nacimiento)) echo "<span class='error'>$err_fecha_nacimiento</span>"; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de primer DNI</label>
                <input class="form-control" type="date" name="fecha_primer_dni">
            </div>
            <div class="mb-3">
                <input class="btn btn-primary" type="submit" value="Enviar">
            </div>
        </form>
        <?php
        if(isset($dni) && isset($correo) && isset($usuario) && isset($nombre) && isset($fecha_nacimiento)) { //está realizando una verificación y luego mostrando información si ciertas variables están definidas. Muestra el resultado final?>
            <p><?php echo $dni ?></p>
            <p><?php echo $correo ?></p>
            <p><?php echo $usuario ?></p>
            <p><?php echo $nombre ?></p>
            <p><?php echo $apellidos ?></p>
            <p><?php echo $fecha_nacimiento ?></p>
        <?php } ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>