
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Areas de Figuras</title>
    <!--3. Haz un formulario con un radio buttom para elegir circulo, triangulo y cuadrado
    y calcular su area en cada caso. De mometo poner todos los input necesarios-->
</head>
<body>

    <?php

        $figura = $_POST["figura"];
        
        

    ?>

    <form action="" method="POST">
        <input type="radio" name="figura" value="circulo" checked>Circulo <br> <!--Checked par que este marcado predeterminadamente-->
        <input type="radio" name="figura" value="circulo">Cuadrado <br>
        <input type="radio" name="figura" value="circulo">Triangulo <br>

        <label for="radio">Radio</label>
        <input type="number" id="radio" name="radio">

        <label for="lado">Lado</label>
        <input type="number" id="lado" name="lado">

        <label for="base">Base</label>
        <input type="number" id="base" name="base">

        <label for="Altura">Altura</label>
        <input type="number" id="altura" name="altura">

        <input type="submit">

    </form>
</body>
</html>

