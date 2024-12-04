<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJERCICIO 3</title>
    <?php
        error_reporting( E_ALL );
        ini_set("display_errors", 1 );    
    ?>
</head>
<body>
      <!-- Formulario-->
      <form action="" method="post">
        <label for="a">Número a:</label>
        <input type="number" name="a" placeholder="Ingresa el valor de a"><br><br>

        <label for="b">Número b:</label>
        <input type="number" name="b" placeholder="Ingresa el valor de b"><br><br>

        <input type="submit" value="Buscar primos">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //recojo valores de a y b del formulario
        $a = $_POST['a'];
        $b = $_POST['b'];

        echo "<h3>Números primos entre $a y $b:</h3>";

        // Recorremos desde a hasta b
        for ($i = $a; $i <= $b; $i++) {
            $esPrimo = true;

            if ($i > 1) { // Solo los números mayores que 1 son primos
                for ($j = 2; $j < $i; $j++) { //empezamos en 2 al igual q los numeros primos
                    if ($i % $j == 0) {
                        $esPrimo = false; // Si tiene divisor, no es primo
                    }
                }
                // Si es primo, se muestra
                if ($esPrimo) {
                    echo $i . "<br>";
                }
            }
        }
    }
    ?>
    
</body>
</html>