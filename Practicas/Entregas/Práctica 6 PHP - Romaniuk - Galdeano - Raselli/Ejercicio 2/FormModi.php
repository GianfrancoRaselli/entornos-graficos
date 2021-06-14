<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificacion</title>
</head>
<body>
<?php
    include ("conexion.inc");
    //Captura datos desde el Form anterior
    $vCiudad = $_POST['Ciudad'];
    //Arma la instrucción SQL y luego la ejecuta
    $vSql = "SELECT * FROM capitales WHERE ciudad ='$vCiudad' ";
    $vResultado = mysqli_query($link, $vSql) or die (mysqli_error($link));;
    $fila = mysqli_fetch_array($vResultado);
    if(mysqli_num_rows($vResultado) == 0) {
        echo ("Capital Inexistente...!!! <br>");
        echo ("<A href='FormModiIni.html'>Continuar</A>");
    }
    else {
    
    ?>

    <form action="Modi.php" method="POST" name="FormModi">
        <table width="356">
            <tr>
                <td width="103">Ciudad: </td>
                <td width="243"> 
                    <input type="text" name="Ciudad" value="<?php echo($fila['ciudad']); ?>">
                </td>
            </tr>
            <tr>
                <td width="103">País: </td>
                <td width="243"> 
                    <input type="text" name="Pais" value="<?php echo($fila['pais']); ?>">
                </td>
            </tr>
            <tr>
                <td width="103">Habitantes: </td>
                <td width="243"> 
                    <input type="text" name="Hab"  value="<?php echo($fila['habitantes']); ?>">
                </td>
            </tr>
            <tr>
                <td width="103">Superficie: </td>
                <td width="243"> 
                    <input type="text" name="Sup" value="<?php echo($fila['superficie']); ?>">
                </td>
            </tr>
            <tr>
                <td width="103">¿Tiene Metro?: </td>
                <td width="243">                     
                    <input type="checkbox" name="TieneMetro" <?php if ($fila['tieneMetro']): ?> checked="" <?php endif; ?>  />
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center"> <input type="SUBMIT" name="Submit" value="Modificar"></td>
            </tr>
        </table>
    </form>

<?php
    }
    // Liberar conjunto de resultados
    mysqli_free_result($vResultado);
    // Cerrar la conexion
    mysqli_close($link);
?>
</body>
</html>