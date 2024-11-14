<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cogiendo datos con POST</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>

<body>

    <?php

        if (isset($_POST['enviar'])) {
            $num1 = $_POST['num1'];
            $num2 = $_POST['num2'];

            $suma = $num1 + $num2;
        }

    ?>

    <form method="POST" > <!--action="ruta del fichero que quiero coger la informacion "-->
        <label for="num1">Inserta el numero 1</label>
        <input type="number" id="num1" name="num1" />

        <label for="num1">Inserta el numero 2</label>
        <input type="number" id="num2" name="num2" />

        <input type="submit" name="enviar" value="Sumar" />

    </form>

    <?php 
        if (isset($_POST['enviar'])) {
            echo "<p>La suma total es: " . $suma . "<p>";
        }
    ?>

</body>

</html>