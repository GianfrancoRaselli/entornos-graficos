<?php
    $link = mysqli_connect("localhost", "root", "") or die ("Problemas de conexión a la base de datos".mysqli_connect_error());
    mysqli_select_db($link, "capitales") or die ( "Upps! Pues va a ser que no se ha podido conectar a la base de datos" );
?>