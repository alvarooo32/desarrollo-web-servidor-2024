<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EJERCICIO 2</title>
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

        <label for="c">Número c:</label>
        <input type="number" name="c" placeholder="Ingresa el valor de c"><br><br>

        <input type="submit" value="Buscar múltiplos">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //valores de a, b y c del formulario
        $a = $_POST['a'];
        $b = $_POST['b'];
        $c = $_POST['c'];

        echo "<h3>Múltiplos de $c entre $a y $b:</h3>";

        // Recorro desde a hasta b
        for ($i = $a; $i <= $b; $i++) {
                // Si el número es múltiplo de c, se muestra
                if ($i % $c == 0) {
                    echo $i . "<br>";
                }
        }
        
    }
    ?>
</body>
</html>