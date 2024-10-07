<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejemplos</title>
  <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php
  /**
   * TODOS LOS ARRYS EN PHP SPN ASOCIATIVOS, COMO LLOS MAP EN JAVA 
   * 
   * TIENEN PARES CLAVE-VALOR
   */
  
  $numeros = [5,10,9,6,7,4];
  $numeros = array(6,10,9,4,3);
  print_r($numeros); 
  
  echo "<br></br>";

  $animales = ["Perro", "Gato", "Ornitorrinco", "Suricato", "Capibara"];
  $animales = [
    "A01" => "Perro",
    "A02" => "Gato",
    "A03" => "Ornitorrinco",
    "A04" => "Suricato",
    "A05" => "Capibara",
  ];
  //print_r($animales);

  $animales = array(
    "Perro",
    "Gato",
    "Ornitorrinco",
    "Suricato",
    "Capibara",
  );
  //print_r($animales);

  echo "<p>". $animales[3] . "</p>";

  $animales[2] = "Koala";
  $animales[6] = "Iguana";
  $animales["A01"] = "Elefante";
  array_push($animales, "Morsa", "Foca");
  $animales[] = "Ganso";
  unset($animales[1]); //elimina el array

  $animales = array_values($animales);

  echo "<h3>Lista de animales con FOR</h3>";
  echo "<ol>";
  for($i = 0; $i < count($animales); $i++){
    echo "<li>$animales[$i]</li>";
  }


 
  $cantidad_animales = count($animales);

  echo "<h3> Hay $cantidad_animales animales</h3>";

  //print_r($animales);

  /**
   * "4312 TDZ" => "Audi"
   * "1122 FFF" => "Mercedes CLR"
   * 
   * CEAR EL ARRAY CON 3 COCHES
   * AÑADIR 2 COCHES CON SUS MATRICULAS
   * AÑADIR UN COCHE SIN MATRICULA
   * BORRAR EL COCHE SIN MATRICULA
   * RESETEAR LAS CLAVES Y AL,ACENAR EL RESULTADO EN OTRO ARRAY
   */

   $coches = [
    "4312 TDZ" => "Audi",
    "1122 FFF" => "Mercedes CLR",
    "4253 JKL" => "Ferrari 355",
    "9929 KLC" => "Zentorno",
   ];
   $coches["6666 KKK"] = "Seat Ibiza";
   $coches["71229 YGV"] = "Fiat Multipla";
 
   //array_push($coches, "Peugeot 207");
   //unset($coches[0]);//borro un coche


   $coches_indexados = array_values($coches);
  
   //print_r($coches);
   echo "<br></br>";
   //print_r($coches_indexados);
   echo "<h3>Lista de coches  FOREACH</h3>";
   echo "<ol>";
   foreach($coches as $coche){
    echo "<li>$coche</li>";
   }
   echo "</ol>";
  
   echo "<h3>Lista de coches  FOREACH con CLAVE</h3>";
   echo "<ol>";
   foreach($coches as $matriculas => $coche){
    echo "<li>$matricula, $coche</li>";
   }
   echo "</ol>";
  ?>
  
  <table>
    <caption>Coches</caption>
    <thead>
      <tr>
        <th>Matrícula</th>
        <th>coche</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>2133 FSD</td>
        <td>Ferrari 355</td>
        
        <?php
        foreach($coches as $matriculas => $coche){ ?>
          <tr>
            <td><?php echo $matricula ?> </td>
            <td><?php echo $coche ?> </td>
          </tr>
        <?php } ?>
      </tr>
    </tbody>
  </table>
  

</body>
</html>