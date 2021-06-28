<?php
ob_start("ob_gzhandler");
include("conexion.inc");
session_start();
if(isset($_SESSION['carro']))
$carro=$_SESSION['carro'];
else $carro=false;
$qry=mysqli_query($link,"select * from catalogo order by producto asc")or die(mysqli_error($link));
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
       
        .catalogo {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 9px;
        color: #333333;
        }
      
    </style>

</head>
<body>
<table width="272" align="center" cellpadding="0" cellspacing="0" style="border: 1px solid #000000;">
        <tr valign="middle" bordercolor="#FFFFFF" bgcolor="#DFDFDF" class="catalogo">
            <td width="170"><strong>Producto</strong></td>
            <td width="77"><strong>Precio</strong></td>
            <td width="25" align="right"><a href="vercarrito.php?<?php echo SID ?>" title="Ver el contenido del carrito"><img src="./img/vercarrito.png" width="25" height="21" border="0"></a></td>
        </tr>
    <?php
        while($row=mysqli_fetch_assoc($qry))
    {
    ?>
        <tr valign="middle" class="catalogo">
            <td><?php echo $row['producto'] ?></td>
            <td><?php echo $row['precio'] ?></td>
            <td align="center">
                <?php
                    if(!$carro || !isset($carro[md5($row['id'])]['identificador']) || $carro[md5($row['id'])]['identificador']!=md5($row['id']))
                    {
                        ?><a href="agregacar.php?<?php echo SID ?>&id=<?php echo $row['id']; ?>"><img src="./img/agregarcar.png" width="25px"  border="0" title="Agregar al Carrito"></a><?php
                    }
                    else
                    {
                        ?><a href="borracar.php?<?php echo SID ?>&id=<?php echo $row['id']; ?>"><img src="./img/borrarcar.png" border="0" title="Quitar del Carrito"></a><?php
                    } 
                ?>
             </td>
        </tr>
    <?php 
    } 

    ?>
</table>
</body>
</html>
<?php
ob_end_flush();
?>
