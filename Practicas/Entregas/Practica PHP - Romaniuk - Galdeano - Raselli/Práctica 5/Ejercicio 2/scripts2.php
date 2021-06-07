<?php
if(!isset($_POST["send"]))
{
    if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message']) && !empty($_POST['asunto']))
        {
            $name=$_POST['name'];
            $email=$_POST['email'];
            $asunto=$_POST['asunto'];
            $message=$_POST['message'];
            $emisor="xx@xx.com";

            $headers .= "Content-type:text/html; charset=iso-8859- 1\r\n"; 
            $headers .= "From: $emisor\r\n";
          
            $mail= mail($email,$name,$asunto,$message,$headers);
          
            if ($mail)
            {
                echo "<h4> Mail enviado exitosamente.</h4>";
            }
            else
            {
                echo '<h4>Error en el envío.</h4>';
            }
        }
}
?>