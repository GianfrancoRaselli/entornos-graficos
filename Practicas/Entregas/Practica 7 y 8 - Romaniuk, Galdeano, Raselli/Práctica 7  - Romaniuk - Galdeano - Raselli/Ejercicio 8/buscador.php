<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http‐equiv="Content‐Type" content="text/html; charset=utf‐8" />
    <title>Untitled Document</title>
</head>
<body>
<table>
<?php
    include("Conexion.inc");
    $pal=$_POST['palabra'];
    if($pal) {
        $resp = mysqli_query($link, "select * from buscador where canciones LIKE '%".$pal."%'") or die (mysqli_error());
        
        if(mysqli_num_rows($resp) == "0") {
            echo "<p>No hay resultados respecto a la palabra que busca.</p>";
            echo "<p><a href='FormBuscador.html'>Volver al Buscador de Canciones</a></p>";
        } else {
            echo "<center><strong>RESULTADOS DE BUSQUEDA</strong></center><br>";
            while($cat = mysqli_fetch_array($resp)) {?>
                <table>
                    <td>
                        <?php echo ($cat['canciones']); ?>
                        <?php echo ($cat['autor']); ?>
                        
                    </td>
                </table>
            <?php                 
            }
            echo "<p><a href='FormBuscador.html'>Volver al Buscador de Canciones</a></p>";
        }
    } else {
        echo "<span>Palabra: </span><form name='FormBuscador' method='post' action=''><input name='palabra' type='text' id='palabra'><input type='submit' name='Submit' value='Buscar!'></form>"; 
    }?>
</table>
</body>
</html>