<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
    <?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 );    
    ?>
</head>
<body>    
    <form action="" method="post">
    <label for="temp">Temperatura</label>
    <input type="text" name="temp">
    <br><br>
    <select name="unidad1">
        <option value="celsius">Celsius</option>
        <option value="kelvin">Kelvin</option>
        <option value="fahrenheit">Fahrenheit</option>
    </select>
    <select name="unidad2">
        <option value="celsius">Celsius</option>
        <option value="kelvin">Kelvin</option>
        <option value="fahrenheit">Fahrenheit</option>
    </select>
    <br><br>
    <input type="submit" value="Enviar">
    <br><br><hr>
    </form>

    <!--EJERCICIO 4: Realiza un formulario que funcione a modo de conversor de temperaturas. 
    Se introducirá en un campo de texto la temperatura, y luego tendremos un select para elegir las unidades de dicha temperatura, 
    y otro select para elegir las unidades a las que queremos convertir la temperatura.

    Por ejemplo, podemos introducir "10", y seleccionar "CELSIUS", y luego "FAHRENHEIT". Se convertirán los 10 CELSIUS a su equivalente en FAHRENHEIT.

    En los select se podrá elegir entre: CELSIUS, KELVIN y FAHRENHEIT.-->

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $temp = $_POST["temp"];
            $unidad1 = $_POST["unidad1"];
            $unidad2 = $_POST["unidad2"];

        switch ($unidad1) {
            case "celsius":
                if($unidad2 == "kelvin"){
                    $resultado = $temp + 273;
                } elseif($unidad2 == "fahrenheit"){
                    $resultado = ($temp * 1.8) + 32;
                } else{
                    $resultado = $temp;
                }
                break;
            case "kelvin":
                if($unidad2 == "celsius"){
                    $resultado = $temp - 273;
                } elseif($unidad2 == "fahrenheit"){
                    $resultado = 1.8 * ($temp - 273) + 32;
                } else{
                    $resultado = $temp;
                }
                break;
            case "fahrenheit":
                if($unidad2 == "celsius"){
                   $resultado = ($temp-32) / 1.8;
                } elseif($unidad2 == "kelvin"){
                   $resultado = 5/9 * ($temp - 32) + 273;
                } else{
                    $resultado = $temp;
                }
                break;
            default:
                echo "ERROR, vuelve a intentarlo";
        }

        echo "<h1>La temperatura $temp $unidad1 son: $resultado $unidad2</h1>";

        }
    ?>

</body>
</html>