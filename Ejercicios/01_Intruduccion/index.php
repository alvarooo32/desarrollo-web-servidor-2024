<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>

    <?php
    DEFINE("PI", 3.14);

    echo "<h1>PI vale " . PI . "</h1>";

    $mensaje = "Hola mundo";
    echo "<h1>El mensaje es $mensaje</h1>";
    
    $numero = 3;
    var_dump($numero); //Sale la localizacion del archivo + tipo + valor

    $numero_decimal = 1.0;
    var_dump($numero_decimal);

    $numero_grande = 3e10;
    var_dump($numero_grande);

    $numero= true;
    var_dump($numero);

    $mensaje = "adios mundo";
    var_dump($mensaje);
    ?>
    
    <?php $texto  = "Hola mundo";?>

    <h1><?php echo $texto ?></h1>

</body>
</html>