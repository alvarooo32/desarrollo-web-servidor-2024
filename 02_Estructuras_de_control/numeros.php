<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Numeros</title>
</head>
<body>
    
    <?php
    $numero = 0;

    # Forma 1
    if ($numero > 0){
        echo "<p>1 El número $numero es mayor que cero </p>";
    } elseif($numero == 0){
        echo "<p>1 El numero es cero</p>";
    } 
    else{
        echo "<p>1 El numero es menor  que cero</p>";
    }

    # Forma 2
    if ($numero > 0) echo "<p>2 El número $numero es mayor que cero </p>";
    elseif ($numero == 0) echo "<p>2 El numero es cero</p>";
    else echo "<p>2 El numero $numero es menor que cero</p>";

    # Forma 3
    if ($numero > 0):
        echo "<p>3 El número $numero es mayor que cero </p>";
    elseif($numero == 0): echo "<p>3 El numero es cero</p>";
    else: 
        echo "<p>3 El numero $numero es menor que cero</p>";
    endif;
    ?>

    <?php 
    # Rangos [-10,0),[0,10],(10,20)
    $num = -7;
    # and o && parea la conjuncion
    if($num >= -10 && $num < 0){
        echo "<p>El numero $num esta en el rango [-10,0) </p>";
    }elseif($num >= 0 && $num <= 10){
        echo "<p>El número $num esta el rengo [0,10]</p>";
    }elseif($num > 10 && $num >= 20){
        echo "<p>El numero $num esta en el rango (10,20]</p>";   
    }else{
        echo "<p>El numero $num esta fuera del rango";
    }
    /*
        COMPROBAR DE TRES FORMAS DIFERENTES SI EL NUMERO ALEATORIO
        TIENE 1, 2 O 3 DIGITOS
    */
    $numero_aleatorio = rand (1,200);
    $digitos = null;

    if($numero_aleatorio >= 1 && $numero_aleatorio <= 9){
        $digitos = 1;
    }elseif($numero_aleatorio >= 10 && $numero_aleatorio <= 99){
        $digitos = 2;
    }elseif($numero_aleatorio >= 100 && $numero_aleatorio <= 999){
        $digitos = 3;   
    }else{
        $digitos = "ERROR";   
    }
    $digitos_texto = "digitos";
    if($digitos == 1){
        $digitos_texto = "digito";
    }
    echo "<p>El numero tiene $digitos $digitos_texto</p>";
    
    //$numero_aleatorio_decimales = rand(10,100)/10;

    $n = rand(1,3);

    switch($n){
        case 1:
            echo "<p>El numero es 1</p>";
            break;
        case 2:
            echo "El numero es 2";
            break;
        default:
            echo "El numero es 3";
    }
    ?>
    

</body>
</html>