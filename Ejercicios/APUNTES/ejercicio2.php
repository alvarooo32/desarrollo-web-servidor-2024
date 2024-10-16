<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <?php
        $array1 = [];
        $array2 = [];
        $array3 = [];

        //recorro el array1
        for ($i = 0; $i < 5; $i++) {
            $array1[$i] = rand(1,10); 
            echo $array1[$i] . "<br>";
        }
        //recorro el array2
        for ($i = 0; $i < 5; $i++) {
            $array2[$i] = rand(10,100); 
            echo $array2[$i] . "<br>";
        }
        for ($i = 0; $i < count($array3); $i++) {  
            for ($j = 0; $j < 1; $j++) {
                $array3[$i][1]=$array1;
                $array3[$i][2]=$array2;
                echo $videojuegos[$i][$j] . ",";  // Mostrar el elemento
            }
        }
        echo "<br>";  // Salto de línea después de cada fila
        
    
    ?>
</body>
</html>