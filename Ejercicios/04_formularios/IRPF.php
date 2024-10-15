<!--https://www.bankinter.com/blog/finanzas-personales/renta-tramos-irpf-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IRPF</title>
</head>
<body>
    <!--Formulario-->
<form action="" method="post">
        <label for="a">Sueldo:</label>
        <input type="number" name="sueldo" placeholder="Ingresa tu sueldo"><br><br>

        <input type="submit" value="Buscar primos">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //recojo valores de a y b del formulario
        $sueldo = $_POST['sueldo'];
        if($sueldo <= 12450){
            $renta = $sueldo * 0.19;
        }
    }
    ?>
</body>

</html>