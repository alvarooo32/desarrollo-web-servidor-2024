<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
    <?php
        error_reporting( E_ALL ); //Activa la visualizacion de los errores en la pagina
        ini_set("display_errors", 1 );    
    ?>
</head>
<body>
<form action="" method="post"> 
        <label for="text">Numero:</label> 
        <input type="text" name="numero" id="numero" placeholder="Ingresa un numero"> <!--//placeholder para escribir texto dentro del textarea-->

        <br><br>

        <select name="operacion"> //Desplegable para elegir opcion
            <option value="sumatrio">Sumatorio</option>
            <option value="factorial">Factorial</option>
        </select>

        <br><br>

        <input type="submit" value="Calcular"> <!--//Al hacer clic en el botón "Calcular", el navegador enviará (los campos de entrada que el usuario ha completado) -->
        
</form>
<?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") { //verifica si se ha enviado un formulario usando el método POST antes de procesar los datos.
            //valores de los números enviados por el formulario
            $numero = $_POST["numero"];//obtener el valor enviado desde un formulario HTML
            $operacion = $_POST["operacion"];

            $i = 1;
            $resultado1 = 1;
            $resultado2 = 1;
            /*while($i <= $sumatorio){
                $numero += $i;   
                $resultado1 += $i; 
                $i++;
            }
            while($i <= $factorial){
                $numero *= $i;
                $resultado2 *= $i; 
                $i++;*/
            switch($operacion){
                case "sumatorio":
                    while($i <= $sumatorio){
                        $numero += $i;   
                        $resultado1 += $i; 
                        $i++;
                    }
                    echo "<p>El sumatorio es $resultado1</p>";
                    break;
                case "factorial":
                    while($i <= $factorial){
                        $numero *= $i;
                        $resultado2 *= $i; 
                        $i++;
                    }
                    echo "<p>El factorial es $resultado2</p>";
                    break;
            }
        }
        
            /*$resultadoFinal = match($operacion) {             
                "sumatorio" =>  $resultado1,
                
                "factorial" => $resultado2            
            };
            echo "<p>SOLUCIÓN: EL RESULTADO ES $resultadoFinal</p>";        
        }*/
            
        
    ?>
    
</body>
</html>