<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baja</title>
</head>
<body>
    <?php
        include ("conexion.inc");
        
        $vCiudad = $_POST ['Ciudad'];
        $vSql = "SELECT * FROM capitales WHERE ciudad='$vCiudad' ";
        $vResultado = mysqli_query($link, $vSql);
        
        if(mysqli_num_rows($vResultado) == 0)
        {
            echo ("Capital Inexistente...!!! <br>");
            echo ("<A href='FormBajaIni.html'>Continuar</A>");
        }
        else 
        {
            //Arma la instrucción SQL y luego la ejecuta
            $vSql= "DELETE FROM capitales WHERE ciudad = '$vCiudad' ";
            mysqli_query($link, $vSql);

            echo("La capital fue borrada<br>");
            echo("<A href='Menu.html'>Volver al Menu del ABM</A>");
        }
        
        // Liberar conjunto de resultados
        mysqli_free_result($vResultado);
        
        // Cerrar la conexion
        mysqli_close($link);
    ?>
</body>
</html>