<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    if (isset($_SESSION['usuario']))
        {
            echo "Bienvenido ".$_SESSION['usuario'];
        }
    else
        {
        echo "No tiene permitido visitar esta página.";
        }
    session_destroy();
?>
</body>
</html>