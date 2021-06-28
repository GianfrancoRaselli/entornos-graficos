<?php
if(isset($_POST["enviar"])){
    if ($_POST["nombre"] != ""){
        $nombre = $_POST["nombre"];
        setcookie("nombre_cookie", $nombre, time() + 30*24*60*60);
    }  
}
if (isset($_COOKIE["nombre_cookie"])){
    print "<p>El último usuario ingresado fue: $_COOKIE[nombre_cookie]</p>\n";
} 
else{
    echo "No se han introducido usuarios";
}
?>

