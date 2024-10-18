<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1</title>
    <?php
        error_reporting( E_ALL );
        ini_set( "display_errors", 1 );
      ?>
</head>
<body>
    <?php
    $animes = [
        ["Dandan", "Accion" ],
        ["Tragones y mazmorras", "Comedia"],

      ];
    //añado dos mas
    array_push($animes, ["Los diarios de la boticaria", "Historico"]);
    array_push($animes, ["Dota 2", "MOBA"]);
    //elimino el primero del array
    unset($videojuegos[0]);
    //añado 3 columnas mas
    for($i = 0; $i < count($animes); $i++) {
        for ($j = 0; $j < 4; $j++) {
            $animes[$i][2] = rand(1990,2030);
            $animes[$i][3] = rand(1,99);

            if ($videojuegos[$i][2] >= 2024 ){
                $videojuegos[$i][4] = "Ya disponible";
            }else{
                $videojuegos[$i][4] = "Proximamente";
            }
        }
    }

    $_titulo = array_column($animes, 0);
    $_genero = array_column($animes, 1);
    $_año = array_column($animes, 2);
    $_episodios = array_column($animes, 3);
    $_disponibilidad = array_column($animes, 4);
    array_multisort($_genero,
                    $_año,
                    $_titulo);
       
    ?>
    <table>
      <thead>
        <tr>
          <th>Titulo</th>
          <th>Genero</th>
          <th>Año</th>
          <th>Episodios</th>
          <th>Disponibilidad</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach($animes as $anime){
            //echo $videojuego[0]; para mostrar alguna columna
            
            list($titulo, $genero, $año,$episodios,$disponibilidad) = $anime; ?>
            <tr>
                <td><?php echo $titulo ?></td>
                <td><?php echo $genero ?></td>
                <td><?php echo $año ?></td> 
                <td><?php echo $episodios ?></td>
                <td><?php echo $disponibilidad ?></td>
            </tr>
        <?php }  ?>
      </tbody>
    </table>
    
</body>
</html>