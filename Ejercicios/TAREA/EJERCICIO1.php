<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJERCICIO 1</title>
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );    
    ?>
</head>
<body>   

    <!-- Formulario HTML -->
    <form action="" method="post">
        <label for="numero1">Número 1:</label>
        <input type="number" name="numero1" placeholder="Ingresa el primer número"><br><br>

        <label for="numero2">Número 2:</label>
        <input type="number" name="numero2" placeholder="Ingresa el segundo número"><br><br>

        <label for="numero3">Número 3:</label>
        <input type="number" name="numero3" placeholder="Ingresa el tercer número"><br><br>

        <input type="submit" value="Calcular el mayor">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            //valores de los números enviados por el formulario
            $num1 = $_POST['numero1'];
            $num2 = $_POST['numero2'];
            $num3 = $_POST['numero3'];

            // Comparamos los tres números para encontrar el mayor
            $mayor = $num1; //cojo el 1 para compararlo con los otros 2

            if ($num2 > $mayor) {
                $mayor = $num2; 
            }

            if ($num3 > $mayor) {
                $mayor = $num3; 
            }

            echo "<h3>El mayor de los tres números es: " . $mayor . "</h3>";
    } 
    else {
            echo "<h3>Por favor, rellena los tres campos antes de calcular.</h3>";
    }
    ?>
   
</body>
</html>