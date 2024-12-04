<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fechas</title>
</head>
<body>
    <?php
    $numero = "2";
    $numero = (int)$numero;


    if($numero == 2){
        echo "EXITO";
    }else{
        echo "NO EXITO";
    }
    /*
        "2" == 2    "2" es igual a 2
        "2" !== 2   "2" no es identico a 2
        2 === 2      2 si es identico a 2
        2 !== 2.0    2 no es identico a 2.0
    */
    $hora = (int)date("G"); // G Hora formato de 0 a 23
    //var_dump($hora);

    /*
        SI $hora ENTRE 6 y 11, es MAÑANA
        SI $hora ENTRE 12 y 14, es MEDIODIA
        SI $hora ENTRE 15 y 20 es TARDE
        SI $hora ENTRE 20 y 0, es NOCHE
        SI $hora ENTRE 20 y 0, es MADRUGADA
    */
    $hora_exacta = date ("H:i:s");

    echo "<h1>$hora_exacta</h1>";

    $dia = date ("l");
    echo "<h2>Hoy es $dia</h2>";

    /*
        TENEMOS CLASE LUNES, MIERCOLES Y VIERNES
        NO TENEMOS EL RESTO

        HACER UN SWITCH QUE DIGA SI HOY TENEMOS CLASE
    */


    switch($dia){
        case "Monday":
        case "Wednesday":
        case "Friday":
            echo "<p>Hoy $dia clase</p>";    
            break;
        default:
        echo "<p>Hoy $dia no hay clase</p>";
    }

    /**
     * CON UNA ESTRUCTURA SWITCH CAMBIAR LA VARIABLE DIA A ESPAÑOL
     * 
     * REESCRIBIR EL SWITCH DE LOS DIAS DE CLASE CON VARIABLE EN ESPAÑOL
     */
 

    ?>
</body>
</html>