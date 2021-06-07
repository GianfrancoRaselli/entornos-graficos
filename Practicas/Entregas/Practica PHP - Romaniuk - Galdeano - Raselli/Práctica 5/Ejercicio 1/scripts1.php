<?php

$destinatario = "xx@xx.com ";
$asunto = "Prueba";
$emisor="federico.roma98@gmail.com";
$cuerpo = "
<html>
<head>
<title>Envio de mail</title>
</head>
    <body>
        <h1>Entornos Graficos</h1>
        <p>
        <b>Ejercicio 1 - Practica 5</b>
        <b>Esto es una prueba de envío de correo a través del servidor<b>
        </p>
    </body>
</html>

";

$headers .= "Content-type:text/html; charset=iso-8859- 1\r\n"; 
$headers .= "From: $emisor\r\n";


if(mail($destinatario,$asunto,$cuerpo,$headers)){
    echo 'El mail se envio correctamente.';
} else {
    echo 'No puedo enviar mail.';
}

?>