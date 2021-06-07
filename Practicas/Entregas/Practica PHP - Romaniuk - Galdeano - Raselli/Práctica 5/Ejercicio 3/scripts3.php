<?php
if(!isset($_POST["send"]))
{
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['friend']) && !empty($_POST['emailfriend']) )
        {
            $name=$_POST['name'];
            $email=$_POST['email']; 
            $friend=$_POST['friend'];
            $emailfriend=$_POST['emailfriend'];
            $asunto="Recomendacion de pagina web";
            $url="https://www.frro.utn.edu.ar/";
            $message="ey $friend visita mi pagina web! $url from: $name";
            
            $headers .= "Content-type:text/html; charset=iso-8859- 1\r\n"; 
            $headers .= "From: $email\r\n";

            $mail= mail($emailfriend,$friend,$asunto,$message,$headers);

            if ($mail)
            {
                echo "<h4> Mail enviado exitosamente.</h4>";
            }
            else {
                echo '<h4>Error en el envío.<h4>';
            }
        }
}
?>