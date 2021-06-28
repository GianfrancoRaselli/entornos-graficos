<?php

if(isset($_POST["estilo"]))
    {
        $estilo = $_POST["estilo"];
        setcookie("estilo", $estilo, time() + (60 * 60 * 24 * 90));
    }

else
    {
    if (isset($_COOKIE["estilo"]))
        {
            $estilo = $_COOKIE["estilo"];
        }
    }

if (isset($estilo))
    {
            echo '<link rel="STYLESHEET" type="text/css" href="' . $estilo . '.css">';
    }

?>